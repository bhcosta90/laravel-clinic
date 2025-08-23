<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Frequency;

final class FrequencyService extends Service
{
    protected function model(): Frequency
    {
        return new Frequency();
    }

    protected function search(): array
    {
        return ['name'];
    }
}
