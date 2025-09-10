<?php

declare(strict_types = 1);

use App\Services\Domain\Scheduling\TimeRounding;
use Carbon\Carbon;

it('rounds up to boundary and not before schedule start', function (): void {
    $r             = new TimeRounding();
    $scheduleStart = Carbon::parse('2025-09-01 09:00:00');

    // exact boundary stays
    $t1 = Carbon::parse('2025-09-01 10:00:00');
    expect($r->roundUpToSlot($scheduleStart, $t1, 30)->toDateTimeString())->toBe('2025-09-01 10:00:00');

    // 10:17 -> 10:30
    $t2 = Carbon::parse('2025-09-01 10:17:00');
    expect($r->roundUpToSlot($scheduleStart, $t2, 30)->toDateTimeString())->toBe('2025-09-01 10:30:00');

    // before schedule start -> schedule start
    $t3 = Carbon::parse('2025-09-01 08:40:00');
    expect($r->roundUpToSlot($scheduleStart, $t3, 30)->toDateTimeString())->toBe('2025-09-01 09:00:00');
});
