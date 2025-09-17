<?php

declare(strict_types = 1);

use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;
use QuantumTecnology\ControllerBasicsExtension\Middleware\LogMiddleware;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
    LogMiddleware::class,
])->group(function (): void {
    Route::get('up', fn () => response()->json(['status' => true]));
    Route::apiResource('users', UserController::class);
});
