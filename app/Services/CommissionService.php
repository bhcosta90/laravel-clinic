<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Commission;
use Illuminate\Container\Attributes\CurrentUser;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class CommissionService extends Service
{
    protected function model(): Commission
    {
        return new Commission();
    }

    protected function index(string $search, ?array $filters = [])
    {
        // Commissions do not have a textual searchable field; rely mostly on filters
        return app(BuilderQuery::class)->execute(new Commission(), ['user' => []], $filters ?: []);
    }
}
