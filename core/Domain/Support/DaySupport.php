<?php

namespace Core\Domain\Support;

class DaySupport
{
    public function byInt(string $week): int
    {
        return match ($week) {
            'monday' => 0,
            'tuesday' => 1,
            'wednesday' => 2,
            'thursday' => 3,
            'friday' => 4,
            'saturday' => 5,
            'sunday' => 6,
            default => $week,
        };
    }

    public function byString(int $day): string
    {
        return match ($day) {
            0 => 'monday',
            1 => 'tuesday',
            2 => 'wednesday',
            3 => 'thursday',
            4 => 'friday',
            5 => 'saturday',
            6 => 'sunday',
            default => $day,
        };
    }
}
