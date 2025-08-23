<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Customer;
use Illuminate\Container\Attributes\CurrentUser;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class CustomerService extends Service
{
    protected function model(): Customer
    {
        return new Customer();
    }

    protected function index(#[CurrentUser] $user, ?string $search, ?array $filters = [])
    {
        return app(BuilderQuery::class)->execute(new Customer(), [], [
            '(byFilter,name;document)' => $search,
        ] + ($filters ?: []));
    }
}
