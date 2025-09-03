<?php

declare(strict_types = 1);

namespace App\Enums\Models\Catalog;

enum TrackingMode: int
{
    case None         = 1;
    case Lot          = 2;
    case Serial       = 3;
    case ExpiryDate   = 4;
    case LotAndExpiry = 5;

    public function getDescription(): string
    {
        return match ($this) {
            self::None         => __('No tracking'),
            self::Lot          => __('Tracked by lot'),
            self::Serial       => __('Tracked by serial number'),
            self::ExpiryDate   => __('Tracked by expiry date'),
            self::LotAndExpiry => __('Tracked by lot and expiry date'),
        };
    }
}
