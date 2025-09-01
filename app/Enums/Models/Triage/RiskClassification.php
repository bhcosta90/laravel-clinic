<?php

declare(strict_types = 1);

namespace App\Enums\Models\Triage;

enum RiskClassification: int
{
    case Blue   = 1;
    case Green  = 2;
    case Yellow = 3;
    case Orange = 4;
    case Red    = 5;

    public static function options(): array
    {
        return array_map(
            fn (RiskClassification $case): array => [
                'name' => $case->color() . ' ' . $case->label(),
                'id'   => $case->value,
            ],
            self::cases()
        );
    }

    public function label(): string
    {
        return match ($this) {
            self::Blue   => __('Blue - Not urgent'),
            self::Green  => __('Green - Little urgency'),
            self::Yellow => __('Yellow - Urgency'),
            self::Orange => __('Orange - Much urgency'),
            self::Red    => __('Red - Emergency'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Blue   => '🔵',
            self::Green  => '🟢',
            self::Yellow => '🟡',
            self::Orange => '🟠',
            self::Red    => '🔴',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Red    => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            self::Orange => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
            self::Yellow => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            self::Green  => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            self::Blue   => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
        };
    }

    public function borderClasses(): string
    {
        return match ($this) {
            self::Red    => 'border-red-300 dark:border-red-700',
            self::Orange => 'border-orange-300 dark:border-orange-700',
            self::Yellow => 'border-yellow-300 dark:border-yellow-700',
            self::Green  => 'border-green-300 dark:border-green-700',
            self::Blue   => 'border-blue-300 dark:border-blue-700',
        };
    }
}
