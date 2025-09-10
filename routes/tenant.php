<?php

declare(strict_types = 1);

use App\Livewire\User\Profile;
use App\Livewire\Users\Index;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function (): void {
    Route::view('/', 'welcome')->name('welcome');

    Route::middleware(['auth'])->group(function (): void {
        Route::view('/dashboard', 'dashboard')->name('dashboard');

        Route::get('/users', Index::class)->name('users.index');

        Route::get('/user/profile', Profile::class)->name('user.profile');

        Route::prefix('admin')->as('admin.')->group(function (): void {
            Route::get('insurances', App\Livewire\Admin\Insurances\Index::class)->name('insurances.index');
            Route::get('procedures', App\Livewire\Admin\Procedures\Index::class)->name('procedures.index');
            Route::get('specialties', App\Livewire\Admin\Specialties\Index::class)->name('specialties.index');
            Route::get('rooms', App\Livewire\Admin\Rooms\Index::class)->name('rooms.index');
            Route::get('patients', App\Livewire\Admin\Patients\Index::class)->name('patients.index');
        });
    });

    require __DIR__ . '/auth.php';
});
