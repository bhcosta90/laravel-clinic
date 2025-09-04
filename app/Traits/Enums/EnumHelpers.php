<?php

declare(strict_types = 1);

namespace App\Traits\Enums;

trait EnumHelpers
{
    public static function tryFromName(string | int | null $name): ?self
    {
        if (blank($name)) {
            return null;
        }

        $name = str($name)->pascal()->toString();

        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }

        return null;
    }
}
