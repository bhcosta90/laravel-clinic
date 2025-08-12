<?php

declare(strict_types = 1);

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Queue\Queue;
use Illuminate\Queue\QueueManager;
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
        $this->configureJob();
    }

    protected function configureJob(): void
    {
        Queue::createPayloadUsing(function (): array {
            $customer = auth()->user()->id;

            return [
                'user_id' => $customer,
            ];
        });

        app(QueueManager::class)->before(function ($event): void {
            $payload = $event->job?->payload();
            $userId  = $payload['user_id'] ?? null;

            if (isset($payload['data']['command']) && blank($userId)) {
                $command = unserialize($payload['data']['command']);

                if (isset($command->user_id)) {
                    $userId = $command->user_id;
                }
            }

            auth()->loginUsingId($userId);
        });
    }
}
