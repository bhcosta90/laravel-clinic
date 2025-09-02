<?php

declare(strict_types = 1);

namespace App\Imports\Location;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

final class LocationImport implements ShouldQueue, ToCollection, WithChunkReading, WithStartRow
{
    public function __construct(public string $type, public string $id)
    {
    }

    public function collection(Collection $collection): void
    {
        Log::info($this->id);
        Log::info($collection);
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
