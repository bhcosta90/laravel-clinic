<?php

declare(strict_types = 1);

namespace App\Enums\Models\Catalog;

enum Hazardous: int
{
    case Flammable             = 1;
    case Corrosive             = 2;
    case Explosive             = 3;
    case CompressedGases       = 4;
    case RadioactiveMaterials  = 5;
    case ControlledMedications = 6;

    public function getDescription(): string
    {
        return match ($this) {
            self::Flammable             => __('Paints, solvents, liquid alcohol'),
            self::Corrosive             => __('Acids, industrial cleaning products'),
            self::Explosive             => __('Fireworks'),
            self::CompressedGases       => __('Oxygen, butane gas'),
            self::RadioactiveMaterials  => __('In some hospital cases'),
            self::ControlledMedications => __('Depending on regulations, may be treated as hazardous'),
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Flammable             => __('Flammable'),
            self::Corrosive             => __('Corrosive'),
            self::Explosive             => __('Explosive'),
            self::CompressedGases       => __('Compressed Gases'),
            self::RadioactiveMaterials  => __('Radioactive Materials'),
            self::ControlledMedications => __('Controlled Medications'),
        };
    }
}
