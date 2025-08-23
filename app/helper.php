<?php

declare(strict_types = 1);

if (!function_exists('numberFormat')) {
    function numberFormat(float | int $number): string
    {
        return Number::currency($number, in: config('app.number_locale'), locale: config('app.ts_number_locale'));
    }
}
