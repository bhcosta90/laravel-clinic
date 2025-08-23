<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Agreement;

final class AgreementService extends Service
{
    protected function model(): Agreement
    {
        return new Agreement();
    }

    protected function search(): array
    {
        return ['name'];
    }
}
