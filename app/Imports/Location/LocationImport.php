<?php

declare(strict_types = 1);

namespace App\Imports\Location;

use App\Enums\Models\Location as LocationEnum;
use App\Services\LocationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

final class LocationImport implements ShouldQueue, ToCollection, WithChunkReading, WithStartRow
{
    public function __construct(public string $id)
    {
        //
    }

    public function collection(Collection $collection): void
    {
        Log::info($this->id);

        foreach ($collection as $rs) {
            [
                $code,
                $street,
                $column,
                $level,
                $position,
                $zone,
                $type,
                $capacity,
                $sequence,
                $control,
                $temperature,
                $status,
            ] = $rs;

            $type    = when(filled($type), fn () => LocationEnum\Type::tryFromName($type) ?: $type);
            $control = when(filled($control), fn () => LocationEnum\Control::tryFromName($control) ?: $control);
            $status  = when(filled($status), fn () => LocationEnum\Status::tryFromName($status) ?: $status);
            $zone    = when(filled($zone), fn () => LocationEnum\Zone::tryFromName($zone) ?: $zone);

            app(LocationService::class)->handle('store', [
                'code'         => $code,
                'type'         => $type,
                'aisle'        => $street,
                'column'       => $column,
                'level'        => $level,
                'position'     => $position,
                'zone'         => $zone,
                'max_capacity' => $capacity,
                'sequence'     => $sequence,
                'control'      => $control,
                'temperature'  => $temperature,
                'status'       => $status,
            ]);
        }
    }

    public function batchSize(): int
    {
        return when(app()->isLocal(), 2, 100);
    }

    public function chunkSize(): int
    {
        return when(app()->isLocal(), 2, 100);
    }

    public function startRow(): int
    {
        return 2;
    }
}
