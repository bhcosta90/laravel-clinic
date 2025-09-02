<?php

declare(strict_types = 1);

namespace App\Enums\Models\Location;

enum Type: int
{
    case Picking   = 1;
    case Buffer    = 2;
    case Receiving = 3;
    case Shipping  = 4;
    case Damage    = 5;

    public function movementTrigger(): string
    {
        return match ($this) {
            self::Picking   => 'Replenishment when empty',
            self::Buffer    => 'Replenish picking',
            self::Receiving => 'Addressing to Picking/Buffer',
            self::Shipping  => 'Loading onto transport',
            self::Damage    => 'Release, return or disposal',
        };
    }
}
