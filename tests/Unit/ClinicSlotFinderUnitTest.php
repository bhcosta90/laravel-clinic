<?php

declare(strict_types = 1);

use App\Services\Domain\Scheduling\Availability;
use App\Services\Domain\Scheduling\ClinicSlotFinder;
use App\Services\Domain\Scheduling\TimeRounding;
use Carbon\Carbon;

function mkSched(int $dow, string $start, string $end, int $slot): object
{
    return (object) ['day_of_week' => $dow, 'start_time' => $start, 'end_time' => $end, 'slot_minutes' => $slot];
}

it('clinic slot finder covers edge branches', function (): void {
    $finder = new ClinicSlotFinder(new TimeRounding(), new Availability());

    // Grouped schedules
    $schedules = collect([
        1 => collect([mkSched(1, '09:00:00', '09:20:00', 15)]), // defaultMinutes 30 -> candidateEnd > eff triggers break
        2 => collect([mkSched(2, '10:00:00', '11:00:00', 30)]), // normal day
    ]);

    $minDate = Carbon::parse('2025-09-01 08:00:00'); // Monday
    $end     = $minDate->copy()->addDays(2);

    // Case 1: require room but pickRoom returns null -> continue path
    $slots1 = $finder->find(
        clinicSchedules: $schedules,
        minDate: $minDate,
        endSearch: $end,
        defaultMinutes: 30,
        requireRoom: true,
        roomCode: null,
        maxSlots: null,
        roomIds: [],
        pickRoom: fn (Carbon $s, Carbon $e): null => null,
    );
    expect($slots1->count())->toBe(0);

    // Case 2: no room required, find first valid slot on Tuesday 10:00 and stop due to maxSlots
    $slots2 = $finder->find(
        clinicSchedules: $schedules,
        minDate: $minDate,
        endSearch: $end,
        defaultMinutes: 30,
        requireRoom: false,
        roomCode: null,
        maxSlots: 1,
        roomIds: [],
        pickRoom: fn (Carbon $s, Carbon $e): null => null,
    );
    expect($slots2->count())->toBe(1);
    expect($slots2->first()['start_at']->toDateTimeString())->toBe('2025-09-02 10:00:00');
});
