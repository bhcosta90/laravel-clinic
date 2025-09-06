<?php

declare(strict_types = 1);

namespace App\Enums\Models\Catalog;

enum Status: int
{
    case Enabled  = 1;
    case Disabled = 2;

    public function label(): string
    {
        return match ($this) {
            self::Enabled  => '🟢 ' . __('Enabled'),
            self::Disabled => '🔴 ' . __('Disabled'),
        };
    }
}
