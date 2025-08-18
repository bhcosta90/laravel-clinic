<?php

declare(strict_types = 1);

use App\Http\Controllers\Admin\V1\Api;
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

        Route::prefix('api')->as('api.')->group(function (): void {
            Route::get('roles/search', [Api\RoleController::class, 'search'])->name('roles.search');
            Route::get('agreements/search', [Api\AgreementController::class, 'search'])->name('agreement.search');
            Route::get('anamnesis-group/search', [Api\AnamnesisGroupController::class, 'search'])->name('anamnesis-group.search');
            Route::get('permissions/search', [Api\PermissionController::class, 'search'])->name('permission.search');
            Route::get('customers/search', [Api\CustomerController::class, 'search'])->name('customer.search');
            Route::get('procedures/search', [Api\ProcedureController::class, 'search'])->name('procedure.search');
            Route::get('payment-methods/search', [Api\PaymentMethodController::class, 'search'])->name('payment-method.search');
            Route::get('users/search', [Api\UserController::class, 'search'])->name('user.search');
        });
    });
});

require __DIR__ . '/auth.php';
