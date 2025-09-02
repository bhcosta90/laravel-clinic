<?php

declare(strict_types = 1);

namespace App\Enums\Models\Location;

enum Control: int
{
    case BatchValidity       = 1;
    case SerialNumber        = 2;
    case System              = 3;
    case Blocked             = 4;
    case SpecialTraceability = 5;

    public function getControlDescriptions(): string
    {
        return match ($this) {
            self::BatchValidity       => 'Location can only store products with batch and expiry date registered.',
            self::SerialNumber        => 'Location can only store products that require a serial number.',
            self::System              => 'Movement to this location is only done via WMS task, not manually.',
            self::Blocked             => 'Indicates the location is restricted (only authorized operators can move items).',
            self::SpecialTraceability => 'Items stored here have extra traceability control (regulatory).',
        };
    }

    public function getControlExamples(): string
    {
        return match ($this) {
            self::BatchValidity       => 'Medicines with expiry date, cosmetics.',
            self::SerialNumber        => 'Electronics, high-value equipment.',
            self::System              => 'Automatic picking location, conveyor, stacker crane.',
            self::Blocked             => 'Safe for controlled medicines (black stripe).',
            self::SpecialTraceability => 'RDC 304/2019 for medicines controlled by ANVISA.',
        };
    }
}
