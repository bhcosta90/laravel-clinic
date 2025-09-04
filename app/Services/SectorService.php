<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Sector;

final class SectorService extends Service
{
    protected function model(): Sector
    {
        return new Sector();
    }

    protected function search(): array
    {
        return ['name'];
    }
}
