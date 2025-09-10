<?php

declare(strict_types = 1);

use App\Models\Patient;
use App\Models\Procedure;
use App\Models\User;
use App\Models\UserSchedule;
use App\Services\Domain\SchedulingService;
use Carbon\Carbon;

afterEach(function (): void {
    Carbon::setTestNow();
});

it('restricts doctors to those linked to the procedure', function (): void {
    $patient = Patient::factory()->code('PZ1')->create();
    $docA    = User::factory()->doctor()->create();
    $docB    = User::factory()->doctor()->create();

    // Both have Tuesday schedules, but we will link procedure only to docB
    UserSchedule::create(['user_id' => $docA->id, 'day_of_week' => 2, 'start_time' => '09:00:00', 'end_time' => '10:00:00', 'slot_minutes' => 30]);
    UserSchedule::create(['user_id' => $docB->id, 'day_of_week' => 2, 'start_time' => '09:00:00', 'end_time' => '10:00:00', 'slot_minutes' => 30]);

    $proc = Procedure::query()->create(['code' => 'X1', 'name' => 'Special', 'min_duration_minutes' => 30, 'max_duration_minutes' => 60]);
    // Link only docB
    DB::table('procedure_user')->insert(['procedure_id' => $proc->id, 'user_id' => $docB->id, 'created_at' => now(), 'updated_at' => now()]);

    Carbon::setTestNow('2025-09-02 08:00:00'); // Tuesday

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId(null)
        ->setProcedureCode($proc->code)
        ->setMinDate(Carbon::now())
        ->find();

    expect($slots->isEmpty())->toBeFalse()
        ->and($slots->first()['doctor_id'])->toBe($docB->id);
});

it('allows any doctor if the procedure has no linked doctors', function (): void {
    $patient = Patient::factory()->code('PZ2')->create();
    $docC    = User::factory()->doctor()->create();
    $docD    = User::factory()->doctor()->create();

    UserSchedule::create(['user_id' => $docD->id, 'day_of_week' => 3, 'start_time' => '11:00:00', 'end_time' => '12:00:00', 'slot_minutes' => 30]);

    $proc = Procedure::query()->create(['code' => 'X2', 'name' => 'General', 'min_duration_minutes' => 30, 'max_duration_minutes' => 60]);
    // No linkage created

    Carbon::setTestNow('2025-09-03 08:00:00'); // Wednesday

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId(null)
        ->setProcedureCode($proc->code)
        ->setMinDate(Carbon::now())
        ->find();

    expect($slots->isEmpty())->toBeFalse()
        ->and($slots->first()['doctor_id'])->toBe($docD->id);
});
