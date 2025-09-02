<?php

declare(strict_types = 1);

namespace App\Imports\Location;

use App\Enums\Models\Location as LocationEnum;
use App\Services\LocationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
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

            $data = [
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
            ];

            if ($location = app(LocationService::class)->handle('findByCode', $code)->first()) {
                app(LocationService::class)->handle('update', $location, $data);
            } else {
                app(LocationService::class)->handle('store', $data);
            }
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
