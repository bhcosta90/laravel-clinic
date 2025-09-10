<?php

declare(strict_types = 1);

use App\Services\Domain\Scheduling\TimeRounding;
use Carbon\Carbon;

it('handles zero remainder and exact schedule start correctly', function (): void {
    $r     = new TimeRounding();
    $start = Carbon::parse('2025-09-01 09:00:00');

    // exactly at schedule start remains same and seconds reset to 0
    $t       = Carbon::parse('2025-09-01 09:00:00');
    $rounded = $r->roundUpToSlot($start, $t, 15);
    expect($rounded->toDateTimeString())->toBe('2025-09-01 09:00:00');
});
