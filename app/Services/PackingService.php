<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Packing;

final class PackingService extends Service
{
    protected function model(): Packing
    {
        return new Packing();
    }

    protected function search(): array
    {
        return ['name'];
    }
}
