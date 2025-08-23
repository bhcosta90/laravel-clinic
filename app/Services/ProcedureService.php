<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Procedure;
use Illuminate\Container\Attributes\CurrentUser;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class ProcedureService extends Service
{
    protected function model(): Procedure
    {
        return new Procedure();
    }

    protected function index(string $search, ?array $filters = [])
    {
        return app(BuilderQuery::class)->execute(new Procedure(), [], [
            '(byFilter,name;code)' => $search,
        ] + ($filters ?: []));
    }
}
