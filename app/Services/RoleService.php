<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Role;
use Illuminate\Container\Attributes\CurrentUser;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class RoleService extends Service
{
    protected function model(): Role
    {
        return new Role();
    }

    protected function index(string $search, ?array $filters = [])
    {
        return app(BuilderQuery::class)->execute(new Role(), ['permissions' => []], [
            '(byFilter,name;slug)' => $search,
        ] + ($filters ?: []));
    }
}
