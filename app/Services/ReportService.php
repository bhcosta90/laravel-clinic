<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Report as ModelReport;
use Illuminate\Container\Attributes\CurrentUser;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class ReportService extends Service
{
    protected function model(): ModelReport
    {
        return new ModelReport();
    }

    protected function index(#[CurrentUser] $user, ?string $search, ?array $filters = [])
    {
        return app(BuilderQuery::class)->execute(new ModelReport(), [], [
            '(byFilter,name;description)' => $search,
        ] + ($filters ?: []));
    }
}
