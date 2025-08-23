<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Transaction;
use Illuminate\Container\Attributes\CurrentUser;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class TransactionService extends Service
{
    protected function model(): Transaction
    {
        return new Transaction();
    }

    protected function index(string $search, ?array $filters = [])
    {
        $includes = [
            'customer' => [],
            'user' => [],
            'paymentMethod' => [],
            'agreement' => [],
        ];

        return app(BuilderQuery::class)->execute(new Transaction(), $includes, [
            '(byFilter,name;description)' => $search,
        ] + ($filters ?: []));
    }
}
