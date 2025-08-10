<?php

declare(strict_types = 1);

namespace App\Enums\Models\Report;

enum Status: int
{
    case Processing = 1;
    case Error      = 2;
    case Completed  = 3;

    public function label(): string
    {
        return match ($this) {
            self::Processing => 'Processing',
            self::Error      => 'Error',
            self::Completed  => 'Completed',
        };
    }
}
