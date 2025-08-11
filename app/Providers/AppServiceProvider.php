<?php

declare(strict_types = 1);

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Carbon::macro('localFormat', fn ($format = 'd/m/Y H:i') => $this->timezone(config('app.client_timezone'))->format($format));
    }

    public function boot(): void
    {
        //        Livewire::setUpdateRoute(fn ($handle) => Route::post('/livewire/update', $handle)
        //            ->middleware(
        //                'web',
        //                InitializeTenancyBySubdomain::class, // or whatever tenancy middleware you use
        //            ));
    }
}
