<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Transaction;

final class TransactionService extends Service
{
    protected function model(): Transaction
    {
        return new Transaction();
    }

    protected function search(): array
    {
        return [];
    }
}
