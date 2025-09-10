<?php

declare(strict_types = 1);

use App\Models\Patient;
use App\Models\User;
use App\Models\UserSchedule;
use App\Services\Domain\SchedulingService;
use Carbon\Carbon;

afterEach(function (): void {
    Carbon::setTestNow();
});

it('supports fluent setters and returns $this for chaining', function (): void {
    $patient = Patient::query()->create(['code' => 'FS1', 'name' => 'Fluent']);
    $doc     = User::factory()->create(['is_doctor' => true]);

    // Monday 09:00-10:00
    UserSchedule::create([
        'user_id'      => $doc->id,
        'day_of_week'  => 1,
        'start_time'   => '09:00:00',
        'end_time'     => '10:00:00',
        'slot_minutes' => 30,
    ]);

    Carbon::setTestNow('2025-09-01 08:00:00');

    $service = new SchedulingService();

    // Chain setters; ensure each returns the same instance
    $same = $service
        ->setPatientCode($patient->code)
        ->setDoctorId($doc->id)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->setDaysToSearch(1)
        ->setDefaultFirstVisitMinutes(30)
        ->setDesiredDurationMinutes(null)
        ->setSpecialtyCode(null)
        ->setMaxSlots(1)
        ->setRoomCode(null)
        ->setRequireRoom(false);

    expect($same)->toBe($service);

    $slots = $service->find();

    expect($slots->isEmpty())->toBeFalse()
        ->and($slots->first()['start_at']->toDateTimeString())->toBe('2025-09-01 09:00:00');
});
