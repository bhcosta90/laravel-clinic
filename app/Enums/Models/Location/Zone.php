<?php

declare(strict_types = 1);

namespace App\Enums\Models\Location;

use App\Traits\Enums\EnumHelpers;

enum Zone: int
{
    use EnumHelpers;

    case A   = 1;
    case B   = 2;
    case C   = 3;
    case FR  = 4;
    case CL  = 5;
    case QA  = 6;
    case RET = 7;
    case DAM = 8;
    case STG = 9;
    case LO  = 10;

    public function description(): string
    {
        return match ($this) {
            self::A   => __('High turnover picking zone (closest to shipping)'),
            self::B   => __('Medium/low turnover picking zone'),
            self::C   => __('Picking zone for bulky or hard-to-access products'),
            self::FR  => __('Refrigerated zone (temperature-controlled products)'),
            self::CL  => __('Controlled products zone (restricted, high-value items)'),
            self::QA  => __('Quarantine zone (items awaiting inspection/quality)'),
            self::RET => __('Returns zone (products returned from customers)'),
            self::DAM => __('Damage zone'),
            self::STG => __('Staging zone (intermediate area for sorting/consolidation)'),
            self::LO  => __('Cross-docking or direct shipping zone'),
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::A   => __('A'),
            self::B   => __('B'),
            self::C   => __('C'),
            self::FR  => __('FR'),
            self::CL  => __('CL'),
            self::QA  => __('QA'),
            self::RET => __('RET'),
            self::DAM => __('DAM'),
            self::STG => __('STG'),
            self::LO  => __('LO'),
        };
    }
}
