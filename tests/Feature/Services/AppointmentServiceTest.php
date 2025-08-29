<?php

declare(strict_types = 1);

use App\Models\Appointment;
use App\Services\AppointmentService;
use Illuminate\Support\Carbon;

it('returns 0 when there are no appointments', function () {
    $user = makeUser();

    $service = app(AppointmentService::class);
    $start   = Carbon::parse('2025-01-01 10:00:00');

    expect($service->verifyQuantityScheduleFromUser($user->id, $start))->toBe(0);
});

it('counts appointment in default slot when only start is given', function () {
    config()->set('date.interval_minutes', 15);
    $user = makeUser();
    // appointment at 10:00, slot = [10:00, 10:15)
    makeAppointment($user, ['date' => '2025-01-01 10:00:05']); // seconds should be ignored

    $service = app(AppointmentService::class);
    $start   = Carbon::parse('2025-01-01 10:00:00');

    expect($service->verifyQuantityScheduleFromUser($user->id, $start))->toBe(1);
});

it('does not count appointment that ends exactly at window start', function () {
    config()->set('date.interval_minutes', 15);
    $user = makeUser();
    // appointment at 09:45 ends at 10:00
    makeAppointment($user, ['date' => '2025-01-01 09:45:00']);

    $service = app(AppointmentService::class);
    $start   = Carbon::parse('2025-01-01 10:00:00');
    $end     = Carbon::parse('2025-01-01 10:30:00');

    expect($service->verifyQuantityScheduleFromUser($user->id, $start, $end))->toBe(0);
});

it('does not count appointment that starts exactly at window end', function () {
    config()->set('date.interval_minutes', 15);
    $user = makeUser();
    // window [10:00, 10:30), appointment at 10:30 should not overlap
    makeAppointment($user, ['date' => '2025-01-01 10:30:00']);

    $service = app(AppointmentService::class);
    $start   = Carbon::parse('2025-01-01 10:00:00');
    $end     = Carbon::parse('2025-01-01 10:30:00');

    expect($service->verifyQuantityScheduleFromUser($user->id, $start, $end))->toBe(0);
});

it('counts appointment that starts before and ends inside the window', function () {
    config()->set('date.interval_minutes', 30);
    $user = makeUser();
    // appointment 09:50-10:20 overlaps with [10:00, 10:30)
    makeAppointment($user, ['date' => '2025-01-01 09:50:00']);

    $service = app(AppointmentService::class);
    $start   = Carbon::parse('2025-01-01 10:00:00');
    $end     = Carbon::parse('2025-01-01 10:30:00');

    expect($service->verifyQuantityScheduleFromUser($user->id, $start, $end))->toBe(1);
});

it('counts appointment that starts inside and ends after the window', function () {
    config()->set('date.interval_minutes', 45);
    $user = makeUser();
    // appointment 10:20-11:05 overlaps with [10:00, 10:30)
    makeAppointment($user, ['date' => '2025-01-01 10:20:00']);

    $service = app(AppointmentService::class);
    $start   = Carbon::parse('2025-01-01 10:00:00');
    $end     = Carbon::parse('2025-01-01 10:30:00');

    expect($service->verifyQuantityScheduleFromUser($user->id, $start, $end))->toBe(1);
});

it('counts only overlapping appointments for the user within the time window', function () {
    config()->set('date.interval_minutes', 15);
    $userA = makeUser();
    $userB = makeUser();

    // Two overlapping for A within [10:00, 11:00)
    makeAppointment($userA, ['date' => '2025-01-01 10:00:00']);
    makeAppointment($userA, ['date' => '2025-01-01 10:00:00']);

    // Non-overlapping for A (outside window)
    makeAppointment($userA, ['date' => '2025-01-01 11:00:00']); // starts at the window end, not overlap

    // Belongs to B (should not count)
    makeAppointment($userB, ['date' => '2025-01-01 10:15:00']);

    $service = app(AppointmentService::class);
    $start   = Carbon::parse('2025-01-01 10:00:00');

    expect($service->verifyQuantityScheduleFromUser($userA->id, $start))->toBe(2);
});

it('counts multiple overlapping appointments and ignores others users', function () {
    config()->set('date.interval_minutes', 15);
    $userA = makeUser();
    $userB = makeUser();

    // Two overlapping for A within [10:00, 11:00)
    makeAppointment($userA, ['date' => '2025-01-01 10:00:00']);
    makeAppointment($userA, ['date' => '2025-01-01 10:30:00']);

    // Non-overlapping for A (outside window)
    makeAppointment($userA, ['date' => '2025-01-01 11:00:00']); // starts at the window end, not overlap

    // Belongs to B (should not count)
    makeAppointment($userB, ['date' => '2025-01-01 10:15:00']);

    $service = app(AppointmentService::class);
    $start   = Carbon::parse('2025-01-01 10:00:00');
    $end     = Carbon::parse('2025-01-01 11:00:00');

    expect($service->verifyQuantityScheduleFromUser($userA->id, $start, $end))->toBe(2);
});

it('works when start is after end (swapped)', function () {
    config()->set('date.interval_minutes', 15);
    $user = makeUser();

    makeAppointment($user, ['date' => '2025-01-01 10:15:00']);

    $service = app(AppointmentService::class);
    $start   = Carbon::parse('2025-01-01 10:30:00');
    $end     = Carbon::parse('2025-01-01 10:00:00'); // reversed

    expect($service->verifyQuantityScheduleFromUser($user->id, $start, $end))->toBe(1);
});

it('normalizes seconds to minute precision', function () {
    config()->set('date.interval_minutes', 15);
    $user = makeUser();

    // an appointment at 10:00:45 should still be treated as starting at 10:00:45 but query uses seconds(0) for window
    makeAppointment($user, ['date' => '2025-01-01 10:00:45']);

    $service = app(AppointmentService::class);
    // window [10:00:00, 10:15:00)
    $start = Carbon::parse('2025-01-01 10:00:02');

    expect($service->verifyQuantityScheduleFromUser($user->id, $start))->toBe(1);
});
