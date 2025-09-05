<?php

declare(strict_types = 1);

use App\Models\Tenant;
use App\Models\Warehouse;

if (!function_exists('numberFormat')) {
    function numberFormat(float | int $number): string
    {
        return Number::currency($number, in: config('app.number_locale'), locale: config('app.ts_number_locale'));
    }
}

if (!function_exists('tenant')) {
    function tenant(?Tenant $tenant = null): ?Tenant
    {
        static $currentTenant = null;

        if (null === $currentTenant || app()->environment('testing')) {
            $currentTenant = $tenant instanceof Tenant ? $tenant : auth()->user()?->tenant;
        }

        return $currentTenant;
    }
}

if (!function_exists('warehouse')) {
    function warehouse(?Warehouse $warehouse = null): ?Warehouse
    {
        static $currentWarehouse = null;

        if (null === $currentWarehouse || app()->environment('testing')) {
            $currentWarehouse = $warehouse instanceof Warehouse ? $warehouse : auth()->user()?->warehouse;
        }

        return $currentWarehouse;
    }
}
