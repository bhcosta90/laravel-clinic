<?php

declare(strict_types = 1);

namespace App\Enums\Models\Sku;

enum UnitOfMeasure
{
    case UN;
    case CX;
    case FD;
    case KG;
    case G;
    case L;
    case ML;
    case PALLET;
    case M2;
    case M3;
    case KIT;

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
            self::PALLET => __('Pallet'),
            self::M2     => __('Square meter'),
            self::M3     => __('Cubic meter'),
            self::KIT    => __('Kit / Set'),
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
            self::PALLET => __('Stock in closed pallet units (with several SKUs or same SKU)'),
            self::M2     => __('Materials sold by area (floor, fabric)'),
            self::M3     => __('Volumetric products (sand, gravel, bulk liquids)'),
            self::KIT    => __('When the SKU is composed of multiple items (e.g.: promotional kit)'),
        };
    }
}
