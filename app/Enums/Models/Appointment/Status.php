<?php

declare(strict_types=1);

namespace App\Enums\Models\Appointment;

enum Status: int
{
    case Scheduled = 1;
    case Confirmed = 2;
    case Finished  = 3;

    public function label(): string
    {
        return match ($this) {
            self::Scheduled => 'Scheduled',
            self::Confirmed => 'Confirmed',
            self::Finished  => 'Finished',
        };
    }
}
