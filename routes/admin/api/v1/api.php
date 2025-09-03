<?php

declare(strict_types = 1);

use App\Http\Controllers\Admin\V1\Api;
use Illuminate\Support\Facades\Route;

Route::get('roles/search', [Api\RoleController::class, 'search'])->name('roles.search');
Route::get('agreements/search', [Api\AgreementController::class, 'search'])->name('agreement.search');
Route::get('anamnesis-group/search', [Api\AnamnesisGroupController::class, 'search'])->name('anamnesis-group.search');
Route::get('permissions/search', [Api\PermissionController::class, 'search'])->name('permission.search');
Route::get('customers/search', [Api\CustomerController::class, 'search'])->name('customer.search');
Route::get('procedures/search', [Api\ProcedureController::class, 'search'])->name('procedure.search');
Route::get('payment-methods/search', [Api\PaymentMethodController::class, 'search'])->name('payment-method.search');
Route::get('users/search', [Api\UserController::class, 'search'])->name('user.search');

Route::controller(Api\LocationController::class)->prefix('location')->as('location.')->group(function (): void {
    Route::get('download', 'download')->name('download');
    Route::post('/', 'store')->name('store');
});
