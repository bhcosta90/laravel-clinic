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
            self::Picking   => __('Replenishment when empty'),
            self::Buffer    => __('Replenish picking'),
            self::Receiving => __('Addressing to Picking/Buffer'),
            self::Shipping  => __('Loading onto transport'),
            self::Damage    => __('Release, return or disposal'),
        };
    }
}
