<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Location;

final class LocationService extends Service
{
    protected function model(): Location
    {
        return new Location();
    }

    protected function search(): array
    {
        return ['name'];
    }
}
