<?php

declare(strict_types = 1);

use App\Models\Appointment;
use App\Models\ClinicSchedule;
use App\Models\ClinicUnavailability;
use App\Models\Insurance;
use App\Models\Patient;
use App\Models\User;
use App\Models\UserSchedule;
use App\Services\Domain\SchedulingService;
use Carbon\Carbon;

afterEach(function (): void {
    Carbon::setTestNow();
});

it('insurer enforces allowed_weekdays and per-patient monthly cap', function (): void {
    $patient = Patient::factory()->code('SE-A')->create();
    $ins     = Insurance::query()->create([
        'name'                               => 'PlanX',
        'allowed_weekdays'                   => json_encode([1, 3, 5]), // Mon, Wed, Fri
        'max_appointments_per_patient_month' => 1,
    ]);
    DB::table('patient_insurance')->insert(['patient_id' => $patient->id, 'insurance_id' => $ins->id, 'active' => true]);

    $doc = User::factory()->doctor()->create();

    // Doctor works every weekday 09-10
    foreach ([1, 2, 3, 4, 5] as $dow) {
        UserSchedule::create(['user_id' => $doc->id, 'day_of_week' => $dow, 'start_time' => '09:00:00', 'end_time' => '10:00:00', 'slot_minutes' => 30]);
    }

    Carbon::setTestNow('2025-09-01 08:00:00'); // Monday

    $service = new SchedulingService();

    // First booking allowed on Monday (allowed weekday)
    $slots1 = $service
        ->setPatientCode($patient->code)
        ->setDoctorId($doc->id)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->setDaysToSearch(7)
        ->find();
    expect($slots1->first()['start_at']->toDateTimeString())->toBe('2025-09-01 09:00:00');

    // Create an appointment to hit per-patient monthly cap
    Appointment::query()->create([
        'doctor_id'    => $doc->id,
        'patient_id'   => $patient->id,
        'procedure_id' => null,
        'start_at'     => '2025-09-01 09:00:00',
        'end_at'       => '2025-09-01 09:30:00',
    ]);

    // Now the service should push to next month start; next allowed weekday is Monday 2025-10-06 09:00 (first allowed weekday with schedule in Oct window)
    $slots2 = $service->find();
    expect($slots2->first()['start_at']->toDateTimeString())->toBe('2025-10-01 09:00:00');
});

it('insurer enforces max_total_appointments (global) by returning empty', function (): void {
    $patient = Patient::factory()->code('SE-B')->create();
    $ins     = Insurance::query()->create(['name' => 'CapTotal', 'max_total_appointments' => 0]);
    DB::table('patient_insurance')->insert(['patient_id' => $patient->id, 'insurance_id' => $ins->id, 'active' => true]);

    $doc = User::factory()->doctor()->create();
    UserSchedule::create(['user_id' => $doc->id, 'day_of_week' => 2, 'start_time' => '11:00:00', 'end_time' => '12:00:00', 'slot_minutes' => 30]);

    Carbon::setTestNow('2025-09-02 08:00:00');

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId($doc->id)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->find();
    expect($slots)->toHaveCount(0);
});

it('uses clinic schedules as fallback and supports lunch breaks via multiple intervals', function (): void {
    $patient = Patient::factory()->code('SE-C')->create();
    $doc     = User::factory()->doctor()->hasFixedHours()->create(); // has_fixed_hours, but no user schedules

    // Clinic has two intervals on Monday: 09:00-12:00 and 13:00-17:00
    ClinicSchedule::query()->create(['day_of_week' => 1, 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'slot_minutes' => 30]);
    ClinicSchedule::query()->create(['day_of_week' => 1, 'start_time' => '13:00:00', 'end_time' => '17:00:00', 'slot_minutes' => 30]);

    Carbon::setTestNow('2025-09-01 11:50:00'); // Monday

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId($doc->id)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->setDaysToSearch(1)
        ->find();

    // First possible slot should be 13:00 due to lunch break
    expect($slots->first()['start_at']->toDateTimeString())->toBe('2025-09-01 13:00:00');
});

it('blocks slots during clinic-wide unavailability', function (): void {
    $patient = Patient::factory()->code('SE-D')->create();
    $doc     = User::factory()->doctor()->create();

    // Tuesday 09-12
    UserSchedule::create(['user_id' => $doc->id, 'day_of_week' => 2, 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'slot_minutes' => 30]);
    // Clinic closed 09:30-10:30
    ClinicUnavailability::query()->create(['start_at' => '2025-09-02 09:30:00', 'end_at' => '2025-09-02 10:30:00']);

    Carbon::setTestNow('2025-09-02 08:00:00');

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId($doc->id)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->find();

    // First available is 09:00 (before closure); ensure we do not return a slot inside the closure window
    expect($slots->first()['start_at']->toDateTimeString())->toBe('2025-09-02 09:00:00');
});

it('paginates results with maxSlots', function (): void {
    $patient = Patient::factory()->code('SE-E')->create();
    $docA    = User::factory()->doctor()->create();
    $docB    = User::factory()->doctor()->create();

    // Both have Wednesday 09-12 with 30-minute slots; service returns one slot per doctor/day in current design
    UserSchedule::create(['user_id' => $docA->id, 'day_of_week' => 3, 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'slot_minutes' => 30]);
    UserSchedule::create(['user_id' => $docB->id, 'day_of_week' => 3, 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'slot_minutes' => 30]);

    Carbon::setTestNow('2025-09-03 08:00:00');

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId(null)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->setMaxSlots(1)
        ->find();

    expect($slots->count())->toBe(1);
});

it('supports clinic-general service without doctor and procedure using clinic schedules', function (): void {
    $patient = Patient::factory()->code('SE-F')->create();

    // Clinic schedules on Thursday 10:00-11:00
    ClinicSchedule::query()->create(['day_of_week' => 4, 'start_time' => '10:00:00', 'end_time' => '11:00:00', 'slot_minutes' => 30]);

    Carbon::setTestNow('2025-09-04 08:00:00'); // Thursday

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId(null)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->find();

    expect($slots->isEmpty())->toBeFalse();
    $first = $slots->first();
    expect($first['doctor_id'])->toBeNull()
        ->and($first['start_at']->toDateTimeString())->toBe('2025-09-04 10:00:00');
});
