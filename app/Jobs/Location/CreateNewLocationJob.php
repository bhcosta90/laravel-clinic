<?php

declare(strict_types = 1);

namespace App\Jobs\Location;

use App\Enums\Models\Location\Control;
use App\Enums\Models\Location\Status;
use App\Enums\Models\Location\Type;
use App\Enums\Models\Location\Zone;
use App\Models\LocationModule;
use App\Models\Sector;
use App\Services\LocationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        public ?int $temperature,
        public int $status,
    ) {
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

        app(LocationService::class)->handle('store', [
            'sector_id'    => $sector->id,
            'code'         => $code,
            'type'         => Type::from($this->type),
            'aisle'        => $locationModule->acronym,
            'column'       => $this->column,
            'level'        => $this->level,
            'position'     => $this->position,
            'zone'         => Zone::from($this->zone),
            'max_capacity' => $this->max_capacity,
            'sequence'     => $this->sequence * 100,
            'control'      => when($this->control, fn () => Control::from($this->control)),
            'temperature'  => null,
            'status'       => Status::Enabled,
        ]);
    }
}
