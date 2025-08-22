<?php

declare(strict_types = 1);

namespace App\Abstracts;

use App\Models\User;
use App\Traits\Services\HandlesWithDependencies;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;
use QuantumTecnology\ControllerBasicsExtension\Services\RelationshipService;

abstract class Service
{
    use HandlesWithDependencies;

    abstract protected function model();

    abstract protected function search();

    protected function index(?string $search, ?array $filters = [])
    {

        if (null === $filters) {
            $filters = [];
        }

        if ($search) {
            $filters['byFilter,' . implode(';', $this->search())] = $search;
        }

        if (method_exists($this, 'filters') && $data = $this->handle('filters')) {
            $filters = array_merge($filters, $data);
        }

        $newFilters = [];

        foreach ($filters as $key => $value) {
            $newFilters['(' . $key . ')'] = $value;
        }

        return app(BuilderQuery::class)->execute(new User(), ['role' => []], $newFilters);
    }

    protected function store(array $data)
    {
        return app(RelationshipService::class)->execute($this->model(), $data);
    }

    protected function update($model, array $data)
    {
        return app(RelationshipService::class)->execute($model, $data);
    }

    protected function delete($model): bool
    {
        return $model->delete();
    }
}
