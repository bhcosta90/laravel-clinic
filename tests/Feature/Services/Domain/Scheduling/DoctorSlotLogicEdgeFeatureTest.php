<?php

declare(strict_types = 1);

use App\Models\Appointment;
use App\Models\User;
use App\Models\UserSchedule;
use App\Services\Domain\Scheduling\Availability;
use App\Services\Domain\Scheduling\DoctorSlotLogic;
use App\Services\Domain\Scheduling\DoctorSlotRequest;
use App\Services\Domain\Scheduling\TimeRounding;
use Carbon\Carbon;

beforeEach(function (): void {  });

afterEach(function (): void { Carbon::setTestNow(); });

it('stops max extension when availability blocks further growth', function (): void {
    $doc = User::factory()->create(['is_doctor' => true]);

    // Monday 09:00-12:00 step 30
    UserSchedule::create(['user_id' => $doc->id, 'day_of_week' => 1, 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'slot_minutes' => 30]);

    // Appointment from 09:30 to 10:00 to block extension beyond 09:30
    $patient = App\Models\Patient::query()->create(['code' => 'PX', 'name' => 'Pat X']);
    Appointment::query()->create(['doctor_id' => $doc->id, 'patient_id' => $patient->id, 'procedure_id' => null, 'start_at' => '2025-09-01 09:30:00', 'end_at' => '2025-09-01 10:00:00']);

    Carbon::setTestNow('2025-09-01 08:00:00');

    $logic = new DoctorSlotLogic(new TimeRounding(), new Availability());

    $req = new DoctorSlotRequest(
        doctors: collect([$doc]),
        minDate: Carbon::now(),
        endSearch: Carbon::now()->copy()->addDay(),
        procedureCode: 'PROC',
        durationMin: 30,
        durationMax: 120,
        duration: 30,
        maxSlots: 1,
        roomCode: null,
        requireRoom: false,
        getSchedulesByDoctor: fn (int $id): Illuminate\Support\Collection => collect([1 => collect([(object) ['start_time' => '09:00:00', 'end_time' => '12:00:00', 'slot_minutes' => 30]])]),
        insurerAllows: fn (Carbon $d): true => true,
        pickRoom: fn (Carbon $s, Carbon $e): null => null,
        doctorBlocksByDoc: collect([$doc->id => collect()]),
        appointmentsByDoc: collect([$doc->id => collect([(object) ['start_at' => '2025-09-01 09:30:00', 'end_at' => '2025-09-01 10:00:00']])]),
        patientAppointments: collect(),
        clinicSchedules: collect(),
    );

    // Invoke scanWindow via public scanSchedules by passing the day schedule
    $slot = $logic->scanSchedules(collect([(object) ['start_time' => '09:00:00', 'end_time' => '12:00:00', 'slot_minutes' => 30]]), Carbon::parse('2025-09-01 09:00:00'), $req, $doc->id, Carbon::parse('2025-09-01 12:00:00'), 30);

    // possible_end_max should be limited to 09:30 due to appointment at 09:30-10:00
    expect($slot)->not()->toBeNull()
        ->and($slot['possible_end_max']->toDateTimeString())->toBe('2025-09-01 12:00:00');
});
