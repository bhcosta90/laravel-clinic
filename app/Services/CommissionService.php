<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Commission;

final class CommissionService extends Service
{
    protected function model(): Commission
    {
        return new Commission();
    }

    protected function search(): array
    {
        return ['value', 'due_date', 'payment_date'];
    }
}
