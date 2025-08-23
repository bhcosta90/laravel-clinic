<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\PaymentMethod;
use Illuminate\Container\Attributes\CurrentUser;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class PaymentMethodService extends Service
{
    protected function model(): PaymentMethod
    {
        return new PaymentMethod();
    }

    protected function index(#[CurrentUser] $user, ?string $search, ?array $filters = [])
    {
        return app(BuilderQuery::class)->execute(new PaymentMethod(), [], [
            '(byFilter,name)' => $search,
        ] + ($filters ?: []));
    }
}
