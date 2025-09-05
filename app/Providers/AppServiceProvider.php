<?php

declare(strict_types = 1);

namespace App\Providers;

use App\Http\Middleware\ImpersonateMiddleware;
use Carbon\Carbon;
use Illuminate\Queue\Queue;
use Illuminate\Queue\QueueManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Override;

final class AppServiceProvider extends ServiceProvider
{
    #[Override]
    public function register(): void
    {
        Carbon::macro('localFormat', fn ($format = 'd/m/Y H:i') => $this->timezone(config('app.client_timezone'))->format($format));
    }

    public function boot(): void
    {
        Livewire::setUpdateRoute(fn ($handle) => Route::post('/livewire/update', $handle)
            ->middleware(
                'web',
                ImpersonateMiddleware::class, // or whatever tenancy middleware you use
            ));

        $this->configureJob();
    }

    private function configureJob(): void
    {
        Queue::createPayloadUsing(function (): array {
            $userId = ($user = auth()->user())->id;

            return [
                'tenant_id'    => $user->tenant_id,
                'warehouse_id' => $user->warehouse_id,
                'user_id'      => $userId,
            ];
        });

        app(QueueManager::class)->before(function ($event): void {
            $payload     = $event->job?->payload();
            $userId      = $payload['user_id'] ?? null;
            $tenantId    = $payload['tenant_id'] ?? null;
            $warehouseId = $payload['warehouse_id'] ?? null;

            if (isset($payload['data']['command']) && blank($userId)) {
                $command = unserialize($payload['data']['command']);

                if (isset($command->user_id)) {
                    $userId = $command->user_id;
                }

                if (isset($command->tenant_id)) {
                    $tenantId = $command->tenant_id;
                }

                if (isset($command->warehouse_id)) {
                    $warehouseId = $command->warehouse_id;
                }
            }

            auth()->onceUsingId($userId);

            Log::debug('User ID: ' . $userId);
            Log::debug('Tenant ID: ' . $tenantId);
            Log::debug('Warehouse ID: ' . $warehouseId);
        });
    }
}
