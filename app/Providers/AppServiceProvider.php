<?php

declare(strict_types = 1);

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Override;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

final class AppServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        if (app()->environment('testing')) {
            $this->loadMigrationsFrom([
                database_path('migrations/tenant'),
            ]);
        }
    }

    public function boot(): void
    {
        Livewire::setUpdateRoute(fn ($handle) => Route::post('/livewire/update', $handle)
            ->middleware(
                'web',
                InitializeTenancyByDomain::class, // or whatever tenancy middleware you use
            ));
    }
}
