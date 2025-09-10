<?php

declare(strict_types = 1);

use App\Models\User;
use App\Models\UserSchedule;
use App\Services\Domain\NextAvailableSlotService;
use Carbon\Carbon;

it('returns next slot on same workday, rounded up by slot size', function (): void {

    $user = User::factory()->create();

    // Tuesday schedule 09:00-17:00 with 30-minute slots
    // Carbon dayOfWeek: 2 => Tuesday
    UserSchedule::create([
        'user_id'      => $user->id,
        'day_of_week'  => 2,
        'start_time'   => '09:00:00',
        'end_time'     => '17:00:00',
        'slot_minutes' => 30,
    ]);

    // Set now to Tuesday 10:17
    $now = Carbon::parse('2025-09-02 10:17:00'); // 2025-09-02 is a Tuesday
    Carbon::setTestNow($now);

    $service = new NextAvailableSlotService();
    $next    = $service->getNextAvailable($user->id);

    expect($next)->not()->toBeNull();
    expect($next->toDateTimeString())->toBe('2025-09-02 10:30:00');

    Carbon::setTestNow();
});

it('returns next workday start when called on non-workday', function (): void {

    $user = User::factory()->create();

    // Monday to Friday 09:00-17:00, 60-minute slots
    foreach ([1, 2, 3, 4, 5] as $dow) {
        UserSchedule::create([
            'user_id'      => $user->id,
            'day_of_week'  => $dow,
            'start_time'   => '09:00:00',
            'end_time'     => '17:00:00',
            'slot_minutes' => 60,
        ]);
    }

    // Set now to Sunday 14:00, expect Monday 09:00
    $now = Carbon::parse('2025-09-07 14:00:00'); // Sunday
    Carbon::setTestNow($now);

    $service = new NextAvailableSlotService();
    $next    = $service->getNextAvailable($user->id);

    expect($next)->not()->toBeNull();
    expect($next->toDateTimeString())->toBe('2025-09-08 09:00:00');

    Carbon::setTestNow();
});

it('returns null if user has no schedules', function (): void {

    $user = User::factory()->create();

    $service = new NextAvailableSlotService();
    $next    = $service->getNextAvailable($user->id, Carbon::parse('2025-09-07 10:00:00'));

    expect($next)->toBeNull();
});
