<?php

declare(strict_types = 1);

namespace App\Enums\Models\Triage;

enum RiskClassification: int
{
    case Blue   = 1;
    case Green  = 2;
    case Yellow = 3;
    case Orage  = 4;
    case Red    = 5;

    public static function options(): array
    {
        return array_map(
            fn ($case) => [
                'name' => $case->label(),
                'id'   => $case->value,
            ],
            self::cases()
        );
    }

    public function label(): string
    {
        return match ($this) {
            self::Blue   => $this->color() . ' ' . __('Blue - Not urgent'),
            self::Green  => $this->color() . ' ' . __('Green - Little urgency'),
            self::Yellow => $this->color() . ' ' . __('Yellow - Urgency'),
            self::Orage  => $this->color() . ' ' . __('Orange - Much urgency'),
            self::Red    => $this->color() . ' ' . __('Red - Emergency'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Blue   => '🔵',
            self::Green  => '🟢',
            self::Yellow => '🟡',
            self::Orage  => '🟠',
            self::Red    => '🔴',
        };
    }
}
