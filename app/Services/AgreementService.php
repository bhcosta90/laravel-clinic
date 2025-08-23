<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Agreement;
use Illuminate\Container\Attributes\CurrentUser;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class AgreementService extends Service
{
    protected function model(): Agreement
    {
        return new Agreement();
    }

    protected function index(#[CurrentUser] $user, ?string $search, ?array $filters = [])
    {
        return app(BuilderQuery::class)->execute(new Agreement(), [], [
            '(byFilter,name)' => $search,
        ] + ($filters ?: []));
    }
}
