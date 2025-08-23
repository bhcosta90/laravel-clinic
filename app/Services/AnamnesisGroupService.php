<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\AnamnesisGroup;
use Illuminate\Container\Attributes\CurrentUser;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class AnamnesisGroupService extends Service
{
    protected function model(): AnamnesisGroup
    {
        return new AnamnesisGroup();
    }

    protected function index(string $search, ?array $filters = [])
    {
        return app(BuilderQuery::class)->execute(new AnamnesisGroup(), [], [
            '(byFilter,name;description)' => $search,
        ] + ($filters ?: []));
    }
}
