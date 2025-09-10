<?php

declare(strict_types = 1);

namespace App\Services\Domain\Scheduling;

use Carbon\Carbon;

final class TimeRounding
{
    public function roundUpToSlot(Carbon $scheduleStart, Carbon $time, int $slotMinutes): Carbon
    {
        $candidate = $time->copy();
        $minutes   = $candidate->minute + $candidate->hour * 60;
        $remainder = $minutes % $slotMinutes;

        if (0 !== $remainder) {
            $candidate->addMinutes($slotMinutes - $remainder)->second(0);
        } else {
            $candidate->second(0);
        }

        if ($candidate->lt($scheduleStart)) {
            return $scheduleStart->copy();
        }

        return $candidate;
    }
}
