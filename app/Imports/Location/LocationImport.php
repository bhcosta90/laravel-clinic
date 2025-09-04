<?php

declare(strict_types = 1);

namespace App\Imports\Location;

use App\Enums\Models\Error\Type;
use App\Enums\Models\Location as LocationEnum;
use App\Models\Sector;
use App\Services\ErrorService;
use App\Services\LocationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

final class LocationImport implements ShouldQueue, ToCollection, WithBatchInserts, WithChunkReading, WithStartRow
{
    public function collection(Collection $collection): void
    {
        $locationService = app(LocationService::class);

        foreach ($collection as $rs) {
            [
                $sector,
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

            $type     = when(filled($type), fn (): mixed => LocationEnum\Type::tryFromName($type) instanceof LocationEnum\Type ? LocationEnum\Type::tryFromName($type) : $type);
            $control  = when(filled($control), fn (): mixed => LocationEnum\Control::tryFromName($control) instanceof LocationEnum\Control ? LocationEnum\Control::tryFromName($control) : $control);
            $status   = when(filled($status), fn (): mixed => LocationEnum\Status::tryFromName($status) instanceof LocationEnum\Status ? LocationEnum\Status::tryFromName($status) : $status);
            $zone     = when(filled($zone), fn (): mixed => LocationEnum\Zone::tryFromName($zone) instanceof LocationEnum\Zone ? LocationEnum\Zone::tryFromName($zone) : $zone);
            $sectorId = Sector::firstOrCreate([
                'name' => $sector,
            ])->id;

            $data = [
                'sector_id'    => $sectorId,
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
                'is_imported'  => true,
            ];

            app(ErrorService::class)->handle('registerError', Type::ImportLocation, $code, fn () => ($location = $locationService->handle('findByCode', $code)->first())
                ? $locationService->handle('update', $location, $data)
                : $locationService->handle('store', $data));
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
