<?php

declare(strict_types = 1);

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Models\UserSchedule;
use App\Services\Domain\SchedulingService;
use Carbon\Carbon;

afterEach(function (): void {
    Carbon::setTestNow();
});

it('prevents double booking the same patient at the same time with another doctor', function (): void {
    $patient = Patient::query()->create(['code' => 'PC1', 'name' => 'Pat Conflict']);

    $docA = User::factory()->create(['is_doctor' => true]);
    $docB = User::factory()->create(['is_doctor' => true]);

    // Both doctors work Monday 09:00-12:00 in 30-minute slots
    foreach ([$docA, $docB] as $doc) {
        UserSchedule::create(['user_id' => $doc->id, 'day_of_week' => 1, 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'slot_minutes' => 30]);
    }

    Carbon::setTestNow('2025-09-01 08:00:00'); // Monday

    // Existing appointment for patient with docA at 09:00-09:30
    Appointment::query()->create([
        'doctor_id'  => $docA->id,
        'patient_id' => $patient->id,
        'start_at'   => '2025-09-01 09:00:00',
        'end_at'     => '2025-09-01 09:30:00',
    ]);

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId($docB->id)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->setDaysToSearch(1)
        ->setDefaultFirstVisitMinutes(30)
        ->find();

    // Next available for patient with docB should not be 09:00-09:30 due to conflict; should be 09:30
    expect($slots->isEmpty())->toBeFalse();
    $first = $slots->first();
    expect($first['start_at']->toDateTimeString())->toBe('2025-09-01 09:30:00');
});
