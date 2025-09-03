<?php

declare(strict_types = 1);

namespace App\Enums\Models\Location;

use App\Traits\Enums\EnumHelpers;

enum Type: int
{
    use EnumHelpers;

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

    public function label(): string
    {
        return match ($this) {
            self::Picking   => __('Picking'),
            self::Buffer    => __('Buffer'),
            self::Receiving => __('Receiving'),
            self::Shipping  => __('Shipping'),
            self::Damage    => __('Damage'),
        };
    }
}
