<?php

declare(strict_types = 1);

namespace App\Jobs\LocationModule;

use App\Enums\Queue\Queue;
use App\Models\LocationModule;
use App\Services\LocationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class OrderColumnJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public int $locationModuleId, public string $column)
    {
        $this->onQueue(Queue::Low);
    }

    public function handle(): void
    {
        $locationModule = LocationModule::findOrFail($this->locationModuleId);

        app(LocationService::class)->handle('orderColumn', $locationModule, $this->column);
    }
}
