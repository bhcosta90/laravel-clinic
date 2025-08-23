<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Remedy;
use Illuminate\Container\Attributes\CurrentUser;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class RemedyService extends Service
{
    protected function model(): Remedy
    {
        return new Remedy();
    }

    protected function index(#[CurrentUser] $user, ?string $search, ?array $filters = [])
    {
        return app(BuilderQuery::class)->execute(new Remedy(), [], [
            '(byFilter,name;description)' => $search,
        ] + ($filters ?: []));
    }
}
