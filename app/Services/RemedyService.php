<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Remedy;

final class RemedyService extends Service
{
    protected function model(): Remedy
    {
        return new Remedy();
    }

    protected function search(): array
    {
        return ['name', 'description'];
    }
}
