<?php

declare(strict_types = 1);

use App\Models\Patient;
use App\Models\Specialty;
use App\Models\User;
use App\Models\UserSchedule;
use App\Services\Domain\SchedulingService;
use Carbon\Carbon;

afterEach(function (): void {
    Carbon::setTestNow();
});

it('filters doctors by requested specialty', function (): void {
    $patient = Patient::query()->create(['code' => 'SP1', 'name' => 'Pat One']);

    $ent = Specialty::query()->create(['code' => 'ENT', 'name' => 'Otolaryngologist']);
    $ped = Specialty::query()->create(['code' => 'PED', 'name' => 'Pediatrician']);

    $docEnt = User::factory()->doctor()->specialty($ent)->create();
    $docPed = User::factory()->doctor()->specialty($ped)->create();

    // Tuesday schedule for both
    UserSchedule::create(['user_id' => $docEnt->id, 'day_of_week' => 2, 'start_time' => '09:00:00', 'end_time' => '10:00:00', 'slot_minutes' => 30]);
    UserSchedule::create(['user_id' => $docPed->id, 'day_of_week' => 2, 'start_time' => '09:00:00', 'end_time' => '10:00:00', 'slot_minutes' => 30]);

    Carbon::setTestNow('2025-09-02 08:00:00');

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId(null)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->setSpecialtyCode('ENT')
        ->find();

    expect($slots->isEmpty())->toBeFalse()
        ->and($slots->pluck('doctor_id')->all())->toContain($docEnt->id)
        ->and($slots->pluck('doctor_id')->all())->not()->toContain($docPed->id);
});

it('returns empty when specific doctor does not have the requested specialty', function (): void {
    $patient = Patient::query()->create(['code' => 'SP2', 'name' => 'Pat Two']);

    $ort = Specialty::query()->create(['code' => 'ORT', 'name' => 'Orthopedist']);
    $doc = User::factory()->doctor()->specialty(null)->create(); // no specialty

    // Give doc a schedule
    UserSchedule::create(['user_id' => $doc->id, 'day_of_week' => 3, 'start_time' => '11:00:00', 'end_time' => '12:00:00', 'slot_minutes' => 30]);

    Carbon::setTestNow('2025-09-03 08:00:00');

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId($doc->id)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->setSpecialtyCode('ORT')
        ->find();

    expect($slots)->toHaveCount(0);
});
