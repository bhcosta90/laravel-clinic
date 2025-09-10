<?php

declare(strict_types = 1);

namespace App\Models\Enums\Shared;

enum Status: int
{
    case Disabled = 0;
    case Enabled  = 1;

    public function label(): string
    {
        return match ($this) {
            self::Enabled  => '🟢 ' . __('Enabled'),
            self::Disabled => '🔴 ' . __('Disabled'),
        };
    }
}
