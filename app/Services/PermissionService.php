<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Permission;
use Illuminate\Container\Attributes\CurrentUser;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class PermissionService extends Service
{
    protected function model(): Permission
    {
        return new Permission();
    }

    protected function index(#[CurrentUser] $user, ?string $search, ?array $filters = [])
    {
        return app(BuilderQuery::class)->execute(new Permission(), [], [
            '(byFilter,name;slug)' => $search,
        ] + ($filters ?: []));
    }
}
