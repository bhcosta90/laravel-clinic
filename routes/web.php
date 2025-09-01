<?php

declare(strict_types = 1);

use App\Http\Controllers\Admin\V1\Api;
use App\Livewire\Admin;
use App\Models;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');

Route::get('report/{report:code}/view-file', [Api\ReportController::class, 'viewFile'])->name('report.view-file');

Route::middleware(['auth'])->as('admin.')->prefix('admin')->group(function (): void {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    if (file_exists(base_path('routes/admin/testIgnore.php'))) {
        Route::prefix('test')->as('test.')->group(base_path('routes/admin/testIgnore.php'));
    }

    Route::prefix('v1')->name('v1.')->group(function (): void {
        Route::as('people.')->prefix('people')->group(base_path('routes/admin/v1/people.php'));
        Route::as('registration.')->prefix('registration')->group(base_path('routes/admin/v1/registration.php'));
        Route::as('transactions.')->prefix('transaction')->group(base_path('routes/admin/v1/transaction.php'));
        Route::as('appointments.')->prefix('appointment')->group(base_path('routes/admin/v1/appointment.php'));
        Route::get('triage', Admin\Triage\Index::class)->name('triage.index')->can('viewAny', Models\Triage::class);

        Route::prefix('api')->as('api.')->group(base_path('routes/admin/api/v1/api.php'));
    });
});

require __DIR__ . '/auth.php';
