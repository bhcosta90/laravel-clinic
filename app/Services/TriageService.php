<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Triage;

final class TriageService extends Service
{
    protected function model(): Triage
    {
        return new Triage();
    }

    protected function search(): array
    {
        return ['description'];
    }
}
