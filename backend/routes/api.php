<?php

declare(strict_types=1);

use App\Http\Controllers;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

Route::get('/', fn (): View => view('welcome'));

Route::apiResource('doctors', Controllers\DoctorController::class);
Route::apiResource('specialties', Controllers\SpecialtyController::class);
Route::apiResource('procedures', Controllers\ProcedureController::class);
Route::apiResource('rooms', Controllers\RoomController::class);
Route::apiResource('patients', Controllers\PatientController::class);
