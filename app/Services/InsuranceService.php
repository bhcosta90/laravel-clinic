<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\Insurance;
use Costa\Service\Service;

final class InsuranceService extends Service
{
    protected function model(): Insurance
    {
        return new Insurance();
    }

    protected function search(): array
    {
        return ['name'];
    }
}
