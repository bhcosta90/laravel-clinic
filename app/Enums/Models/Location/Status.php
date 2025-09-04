<?php

declare(strict_types = 1);

namespace App\Enums\Models\Location;

use App\Traits\Enums\EnumHelpers;

enum Status: int
{
    use EnumHelpers;

    case Enabled  = 1;
    case Disabled = 2;
    case Blocked  = 3;

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Disabled => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            self::Blocked  => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
            self::Enabled  => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Disabled => '🔴 ' . __('Disabled'),
            self::Blocked  => '🟡 ' . __('Blocked'),
            self::Enabled  => '🟢 ' . __('Enabled'),
        };
    }
}
