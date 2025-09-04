<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\LocationModule;

final class LocationModuleService extends Service
{
    protected function model(): LocationModule
    {
        return new LocationModule();
    }

    protected function search(): array
    {
        return ['name'];
    }
}
