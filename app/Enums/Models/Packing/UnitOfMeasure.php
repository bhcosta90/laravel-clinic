<?php

declare(strict_types = 1);

namespace App\Enums\Models\Packing;

enum UnitOfMeasure: int
{
    case UN      = 1;
    case CX      = 2;
    case FD      = 3;
    case KG      = 4;
    case G       = 5;
    case L       = 6;
    case ML      = 7;
    case Pallet  = 8;
    case M2      = 9;
    case M3      = 10;
    case Kit     = 11;
    case Display = 12;

    public function name(): string
    {
        return match ($this) {
            self::UN     => __('Unit'),
            self::CX     => __('Box'),
            self::FD     => __('Bundle'),
            self::KG     => __('Kilogram'),
            self::G      => __('Gram'),
            self::L      => __('Liter'),
            self::ML     => __('Milliliter'),
            self::Pallet => __('Pallet'),
            self::M2     => __('Square meter'),
            self::M3     => __('Cubic meter'),
            self::Kit    => __('Kit / Set'),
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::UN     => __('Products counted piece by piece (medicine box, bottle, electronics)'),
            self::CX     => __('Stock accounted by box (may contain several internal units)'),
            self::FD     => __('Used for large packages or “bundles” of products (e.g.: bundle of water bottles)'),
            self::KG     => __('Products sold/weighed by weight (meat, grains, chemicals)'),
            self::G      => __('Same logic, but for smaller units'),
            self::L      => __('Liquid products accounted by volume'),
            self::ML     => __('Used for small bottles or cosmetics'),
            self::Pallet => __('Stock in closed pallet units (with several SKUs or same SKU)'),
            self::M2     => __('Materials sold by area (floor, fabric)'),
            self::M3     => __('Volumetric products (sand, gravel, bulk liquids)'),
            self::Kit    => __('When the SKU is composed of multiple items (e.g.: promotional kit)'),
        };
    }
}
