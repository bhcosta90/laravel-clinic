<?php

declare(strict_types = 1);

namespace App\Traits\Enums;

trait EnumHelpers
{
    public static function tryFromName(string $name): ?self
    {
        $name = str($name)->pascal()->toString();

        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }

        return null;
    }
}
