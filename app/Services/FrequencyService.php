<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Frequency;
use Illuminate\Container\Attributes\CurrentUser;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class FrequencyService extends Service
{
    protected function model(): Frequency
    {
        return new Frequency();
    }

    protected function index(#[CurrentUser] $user, ?string $search, ?array $filters = [])
    {
        return app(BuilderQuery::class)->execute(new Frequency(), [], [
            '(byFilter,name)' => $search,
        ] + ($filters ?: []));
    }
}
