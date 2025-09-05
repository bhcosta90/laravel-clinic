<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Ean;

final class EanService extends Service
{
    protected function model(): Ean
    {
        return new Ean();
    }

    protected function search(): array
    {
        return ['name'];
    }
}
