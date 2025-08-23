<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\AnamnesisItem;
use Illuminate\Container\Attributes\CurrentUser;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class AnamnesisItemService extends Service
{
    protected function model(): AnamnesisItem
    {
        return new AnamnesisItem();
    }

    protected function index(#[CurrentUser] $user, ?string $search, ?array $filters = [])
    {
        return app(BuilderQuery::class)->execute(new AnamnesisItem(), ['anamnesisGroup' => []], [
            '(byFilter,name;description)' => $search,
        ] + ($filters ?: []));
    }
}
