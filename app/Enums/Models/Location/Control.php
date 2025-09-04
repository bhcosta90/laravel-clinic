<?php

declare(strict_types = 1);

namespace App\Enums\Models\Location;

use App\Traits\Enums\EnumHelpers;

enum Control: int
{
    use EnumHelpers;

    case BatchValidityAndSerialNumber = 1;
    case BatchValidity                = 2;
    case SerialNumber                 = 3;
    case System                       = 4;
    case Blocked                      = 5;
    case SpecialTraceability          = 6;

    public function getControlDescriptions(): string
    {
        return match ($this) {
            self::BatchValidity                => __('Location can only store products with batch and expiry date registered.'),
            self::SerialNumber                 => __('Location can only store products that require a serial number.'),
            self::BatchValidityAndSerialNumber => __('Location can only store products with batch and expiry date registered, and also require a serial number.'),
            self::System                       => __('Movement to this location is only done via WMS task, not manually.'),
            self::Blocked                      => __('Indicates the location is restricted (only authorized operators can move items).'),
            self::SpecialTraceability          => __('Items stored here have extra traceability control (regulatory).'),
        };
    }

    public function getControlExamples(): string
    {
        return match ($this) {
            self::BatchValidity                => __('Medicines with expiry date, cosmetics.'),
            self::SerialNumber                 => __('Electronics, high-value equipment.'),
            self::BatchValidityAndSerialNumber => __('Medicines with expiry date, cosmetics, electronics, high-value equipment.'),
            self::System                       => __('Automatic picking location, conveyor, stacker crane.'),
            self::Blocked                      => __('Safe for controlled medicines (black stripe).'),
            self::SpecialTraceability          => __('RDC 304/2019 for medicines controlled by ANVISA.'),
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::BatchValidity                => __('Batch validity'),
            self::SerialNumber                 => __('Serial number'),
            self::BatchValidityAndSerialNumber => __('Batch validity and serial number'),
            self::System                       => __('System'),
            self::Blocked                      => __('Blocked'),
            self::SpecialTraceability          => __('Special traceability'),
        };
    }
}
