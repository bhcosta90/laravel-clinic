<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Route;

Route::namespace('App\\Http\\Controllers\\Api')->as('api.')->group(function () {
    Route::namespace('V1')->as('v1.')->prefix('v1')->group(function () {
        Route::namespace('Doctor')->as('doctor.')->prefix('doctors/{doctor_id}')->group(function () {
            Route::apiResource('schedules', 'ScheduleController');
        });
        Route::apiResource('doctors', 'DoctorController');

        Route::get('{service}/next-code', 'NextCodeController');
        Route::apiResource('procedures', 'ProcedureController');
        Route::apiResource('specialties', 'SpecialtyController');
        Route::apiResource('patients', 'PatientController');
        Route::apiResource('rooms', 'RoomController');
    });
});
