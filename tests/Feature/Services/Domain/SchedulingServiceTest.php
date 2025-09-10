<?php

declare(strict_types = 1);

use App\Models\Appointment;
use App\Models\DoctorUnavailability;
use App\Models\Insurance;
use App\Models\Patient;
use App\Models\Procedure;
use App\Models\User;
use App\Models\UserSchedule;
use App\Services\Domain\SchedulingService;
use Carbon\Carbon;

afterEach(function (): void {
    Carbon::setTestNow();
});

it('returns empty when patient not found', function (): void {
    $service = new SchedulingService();
    $slots   = $service->setPatientCode('UNKNOWN')->setDoctorId(null)->setProcedureCode(null)->setMinDate(Carbon::parse('2025-09-08 09:00:00'))->find();
    expect($slots)->toHaveCount(0);
});

it('applies insurer min days in advance', function (): void {
    $patient = Patient::factory()->code('PX')->create();
    $insurer = Insurance::query()->create(['name' => 'ACME', 'min_days_in_advance' => 3]);
    // link patient to insurer
    DB::table('patient_insurance')->insert(['patient_id' => $patient->id, 'insurance_id' => $insurer->id, 'active' => true]);

    $doctor = User::factory()->doctor()->create();
    // Wednesday schedule (3) 09-17 with 60
    UserSchedule::create(['user_id' => $doctor->id, 'day_of_week' => 3, 'start_time' => '09:00:00', 'end_time' => '17:00:00', 'slot_minutes' => 60]);

    Carbon::setTestNow('2025-09-01 10:00:00'); // Monday

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId($doctor->id)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->find();

    // min days 3 => earliest 2025-09-04 (Thursday). But schedule is Wednesday; so next is 2025-09-10 09:00 (next Wed)
    // Service may return more than one slot (multiple doctors); assert first slot is correct
    expect($slots->isEmpty())->toBeFalse();
    $first = $slots->first();
    expect($first['start_at']->toDateTimeString())->toBe('2025-09-10 09:00:00');
});

it('enforces max monthly appointments by shifting to next month', function (): void {
    $patient = Patient::factory()->code('PMAX')->create();
    $insurer = Insurance::query()->create(['name' => 'Cap', 'max_monthly_appointments' => 1]);
    DB::table('patient_insurance')->insert(['patient_id' => $patient->id, 'insurance_id' => $insurer->id, 'active' => true]);

    $doctor = User::factory()->doctor()->create();

    foreach ([1, 2, 3, 4, 5] as $dow) {
        UserSchedule::create(['user_id' => $doctor->id, 'day_of_week' => $dow, 'start_time' => '09:00:00', 'end_time' => '17:00:00', 'slot_minutes' => 60]);
    }

    Carbon::setTestNow('2025-09-02 08:00:00');

    // Existing appointment this month for patient
    Appointment::query()->create([
        'doctor_id'    => $doctor->id,
        'patient_id'   => $patient->id,
        'procedure_id' => null,
        'start_at'     => '2025-09-03 09:00:00',
        'end_at'       => '2025-09-03 10:00:00',
    ]);

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId($doctor->id)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->find();

    // Should shift to next month start (2025-10-01 Wednesday) -> next workday and schedule start 09:00
    $first = $slots->first();
    expect($first['start_at']->toDateTimeString())->toBe('2025-10-01 09:00:00');
});

it('uses doctor schedules and respects unavailability and appointments', function (): void {
    $patient = Patient::factory()->code('P2')->create();
    $doctor  = User::factory()->doctor()->create();
    // Tuesday 09-12, 30-min
    UserSchedule::create(['user_id' => $doctor->id, 'day_of_week' => 2, 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'slot_minutes' => 30]);

    Carbon::setTestNow('2025-09-02 08:00:00'); // Tuesday

    // Block 09:00-09:30
    DoctorUnavailability::query()->create(['doctor_id' => $doctor->id, 'start_at' => '2025-09-02 09:00:00', 'end_at' => '2025-09-02 09:30:00']);
    // Appointment 09:30-10:00
    Appointment::query()->create(['doctor_id' => $doctor->id, 'patient_id' => $patient->id, 'procedure_id' => null, 'start_at' => '2025-09-02 09:30:00', 'end_at' => '2025-09-02 10:00:00']);

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId($doctor->id)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->find();

    // Next available should align with 30-minute slots after 10:00 block, so 10:30
    $first = $slots->first();
    expect($first['start_at']->toDateTimeString())->toBe('2025-09-02 10:30:00');
});

it('falls back to fixed clinic hours when doctor has_fixed_hours and no schedules', function (): void {
    $patient = Patient::factory()->code('P3')->create();
    $doctor  = User::factory()->doctor()->hasFixedHours()->create(); // fixed hours

    Carbon::setTestNow('2025-09-07 10:00:00'); // Sunday; fallback is Mon-Fri

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId($doctor->id)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->find();

    // Expect Monday 09:00
    $first = $slots->first();
    expect($first['start_at']->toDateTimeString())->toBe('2025-09-08 09:00:00');
});

it('supports procedure min/max with desired duration clamping and possible_end_max expansion', function (): void {
    $patient = Patient::factory()->code('P4')->create();
    $doctor  = User::factory()->doctor()->create();

    foreach ([1, 2, 3, 4, 5] as $dow) {
        UserSchedule::create(['user_id' => $doctor->id, 'day_of_week' => $dow, 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'slot_minutes' => 30]);
    }

    $proc = Procedure::query()->create(['code' => 'PROC1', 'name' => 'Proc', 'min_duration_minutes' => 45, 'max_duration_minutes' => 120]);

    Carbon::setTestNow('2025-09-01 08:55:00'); // Monday

    $service = new SchedulingService();

    // Provide desired 200 mins -> clamp to 120
    $slots = $service
        ->setPatientCode($patient->code)
        ->setDoctorId($doctor->id)
        ->setProcedureCode($proc->code)
        ->setMinDate(Carbon::now())
        ->setDaysToSearch(1)
        ->setDefaultFirstVisitMinutes(30)
        ->setDesiredDurationMinutes(200)
        ->find();

    $first = $slots->first();
    // Start should be 09:00; end_at should be 11:00 (120 min clamped), possible_end_min 09:45, possible_end_max up to 11:00 constrained by schedule 12:00
    expect($first['start_at']->toDateTimeString())->toBe('2025-09-01 09:00:00')
        ->and($first['end_at']->toDateTimeString())->toBe('2025-09-01 11:00:00')
        ->and($first['possible_end_min']->toDateTimeString())->toBe('2025-09-01 09:45:00')
        ->and($first['possible_end_max']->toDateTimeString())->toBe('2025-09-01 11:00:00');
});

it('first visit without procedure uses default duration and returns possible_end bounds equal', function (): void {
    $patient = Patient::factory()->code('P5')->create();
    $doctor  = User::factory()->doctor()->create();
    UserSchedule::create(['user_id' => $doctor->id, 'day_of_week' => 1, 'start_time' => '10:00:00', 'end_time' => '12:00:00', 'slot_minutes' => 30]);

    Carbon::setTestNow('2025-09-01 09:00:00'); // Monday

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId($doctor->id)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->setDaysToSearch(1)
        ->setDefaultFirstVisitMinutes(30)
        ->find();

    $first = $slots->first();
    expect($first['start_at']->toDateTimeString())->toBe('2025-09-01 10:00:00')
        ->and($first['end_at']->toDateTimeString())->toBe('2025-09-01 10:30:00')
        ->and($first['possible_end_min']->toDateTimeString())->toBe('2025-09-01 10:30:00')
        ->and($first['possible_end_max']->toDateTimeString())->toBe('2025-09-01 10:30:00');
});

it('when doctorId is null returns any doctor available', function (): void {
    $patient = Patient::factory()->code('P6')->create();
    $docA    = User::factory()->doctor()->create();
    $docB    = User::factory()->doctor()->create();

    // Only docB has a schedule on Tuesday
    UserSchedule::create(['user_id' => $docB->id, 'day_of_week' => 2, 'start_time' => '11:00:00', 'end_time' => '12:00:00', 'slot_minutes' => 30]);

    Carbon::setTestNow('2025-09-02 08:00:00'); // Tuesday

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId(null)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->find();

    expect($slots->isEmpty())->toBeFalse()
        ->and($slots->first()['doctor_id'])->toBe($docB->id);
});
