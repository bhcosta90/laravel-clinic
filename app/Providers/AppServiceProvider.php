<?php

declare(strict_types = 1);

namespace App\Providers;

use Carbon\Carbon;
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

        Carbon::macro(
            'localFormat',
            fn ($format = 'd/m/Y H:i') => $this->timezone(config('app.client_timezone') ?: config('app.timezone'))
                ->format($format)
        );
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
