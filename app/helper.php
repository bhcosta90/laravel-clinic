<?php

declare(strict_types = 1);

use App\Models\Tenant;

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

        if (null === $currentTenant) {
            $currentTenant = $tenant instanceof Tenant ? $tenant : auth()->user()->tenant;
        }

        return $currentTenant;
    }
}
