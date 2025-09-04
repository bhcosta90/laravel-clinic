<?php

declare(strict_types = 1);

namespace App\Jobs\Location;

use App\Enums\Models\Location\Control;
use App\Enums\Models\Location\Type;
use App\Enums\Models\Location\Zone;
use App\Enums\Queue\Queue;
use App\Models\LocationModule;
use App\Models\Sector;
use App\Services\LocationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;

final class CreateNewLocationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public int $sectorId,
        public int $locationId,
        public int $type,
        public int $column,
        public int $level,
        public int $position,
        public int $zone,
        public ?int $max_capacity,
        public int $sequence,
        public ?int $control,
        public ?string $temperature,
        public int $status,
    ) {
        $this->onQueue(Queue::Low);
    }

    public function handle(): void
    {
        $locationModule = LocationModule::findOrFail($this->locationId);

        $sector = Sector::findOrFail($this->sectorId);
        $code   = sprintf(
            '%s.%s.%s.%s',
            $locationModule->acronym,
            str(__('Column'))->substr(0, 1)->upper() . str($this->column)->padLeft(3, '0'),
            str(__('Level'))->substr(0, 1)->upper() . str($this->level)->padLeft(3, '0'),
            str(__('Position'))->substr(0, 1)->upper() . str($this->position)->padLeft(3, '0'),
        );

        $dataStore = [
            'location_module_id' => $locationModule->id,
            'sector_id'          => $sector->id,
            'code'               => $code,
            'type'               => Type::from($this->type),
            'aisle'              => $locationModule->acronym,
            'column'             => $this->column,
            'level'              => $this->level,
            'position'           => $this->position,
            'zone'               => Zone::from($this->zone),
            'max_capacity'       => $this->max_capacity,
            'sequence'           => $this->sequence + 10,
            'control'            => when($this->control, fn () => Control::from($this->control)),
            'temperature'        => $this->temperature,
            'status'             => $this->status,
        ];

        $location = app(LocationService::class)->handle('findByCode', $code)->first();

        $dataUpdated = Arr::only($dataStore, [
            'sector_id',
            'code',
            'location_module_id',
            'type',
            'zone',
            'max_capacity',
            'sequence',
            'control',
            'temperature',
            'status',
        ]);

        $location
            ? app(LocationService::class)->handle('update', $location, $dataUpdated)
            : app(LocationService::class)->handle('store', $dataStore);
    }
}
