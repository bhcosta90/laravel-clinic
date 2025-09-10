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

it('returns empty when first slot is beyond daysToSearch window', function (): void {
    $patient = Patient::factory()->code('DL-A')->create();
    $doctor  = User::factory()->doctor()->create();

    // Doctor works only on Thursday (day 4). With a 2-day window from Monday 08:00, Thursday is out of range
    UserSchedule::create(['user_id' => $doctor->id, 'day_of_week' => 4, 'start_time' => '09:00:00', 'end_time' => '10:00:00', 'slot_minutes' => 30]);

    Carbon::setTestNow('2025-09-01 08:00:00'); // Monday

    $service = new SchedulingService();
    // Limit to 2 days, so Monday(1) to Wednesday(3) window only; next Monday is 7 days ahead
    $slots = $service
        ->setPatientCode($patient->code)
        ->setDoctorId($doctor->id)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->setDaysToSearch(2)
        ->find();

    expect($slots)->toHaveCount(0);
});

it('finds slot when within the daysToSearch window', function (): void {
    $patient = Patient::factory()->code('DL-B')->create();
    $doctor  = User::factory()->doctor()->create();

    // Tuesday schedule
    UserSchedule::create(['user_id' => $doctor->id, 'day_of_week' => 2, 'start_time' => '11:00:00', 'end_time' => '12:00:00', 'slot_minutes' => 30]);

    Carbon::setTestNow('2025-09-01 08:00:00'); // Monday

    $service = new SchedulingService();
    // Window is [Mon 08:00, Wed 08:00); use 2 days to include Tuesday 11:00 within window
    $slots = $service
        ->setPatientCode($patient->code)
        ->setDoctorId($doctor->id)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->setDaysToSearch(2)
        ->find();

    expect($slots->isEmpty())->toBeFalse()
        ->and($slots->first()['start_at']->toDateTimeString())->toBe('2025-09-02 11:00:00');
});

it('returns empty when insurer min_days_in_advance pushes beyond daysToSearch', function (): void {
    $patient = Patient::factory()->code('DL-C')->create();
    $doctor  = User::factory()->doctor()->create();

    // Daily schedule Mon-Fri 09-10
    foreach ([1, 2, 3, 4, 5] as $dow) {
        UserSchedule::create(['user_id' => $doctor->id, 'day_of_week' => $dow, 'start_time' => '09:00:00', 'end_time' => '10:00:00', 'slot_minutes' => 30]);
    }

    // Attach insurer with min_days_in_advance = 5
    $ins = App\Models\Insurance::query()->create(['name' => 'Lag', 'min_days_in_advance' => 5]);
    DB::table('patient_insurance')->insert(['patient_id' => $patient->id, 'insurance_id' => $ins->id, 'active' => true]);

    Carbon::setTestNow('2025-09-01 08:00:00'); // Monday

    $service = new SchedulingService();
    $slots   = $service
        ->setPatientCode($patient->code)
        ->setDoctorId($doctor->id)
        ->setProcedureCode(null)
        ->setMinDate(Carbon::now())
        ->setDaysToSearch(1)
        ->find();

    // min_days_in_advance=5 -> earliest is Sep 6 (Sat). Window becomes [Sep 6 08:00, Sep 7 08:00),
    // next business slot is Sep 8 09:00 which is outside this 1-day window => empty
    expect($slots)->toHaveCount(0);
});
