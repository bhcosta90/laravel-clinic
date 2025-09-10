<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\Specialty;
use Costa\Service\Service;

final class SpecialtyService extends Service
{
    protected function model(): Specialty
    {
        return new Specialty();
    }

    protected function search(): array
    {
        return ['code', 'name'];
    }
}
