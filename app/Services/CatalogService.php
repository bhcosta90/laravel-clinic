<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Catalog;

final class CatalogService extends Service
{
    protected function model(): Catalog
    {
        return new Catalog();
    }

    protected function search(): array
    {
        return ['name'];
    }
}
