<?php

declare(strict_types = 1);

use App\Services\Domain\Scheduling\Availability;
use App\Services\Domain\Scheduling\ClinicSlotFinder;
use App\Services\Domain\Scheduling\TimeRounding;
use Carbon\Carbon;

it('returns empty when clinic schedules are empty', function (): void {
    $finder = new ClinicSlotFinder(new TimeRounding(), new Availability());
    $slots  = $finder->find(
        clinicSchedules: collect(),
        minDate: Carbon::parse('2025-09-01 08:00:00'),
        endSearch: Carbon::parse('2025-09-02 08:00:00'),
        defaultMinutes: 30,
        requireRoom: false,
        roomCode: null,
        maxSlots: 1,
        roomIds: [],
        pickRoom: fn (): null => null,
    );
    expect($slots->count())->toBe(0);
});
