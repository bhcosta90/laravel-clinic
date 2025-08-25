<?php

declare(strict_types = 1);

namespace App\Abstracts;

use App\Traits\Services\HandlesWithDependencies;
use Illuminate\Database\Eloquent\Model;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;
use QuantumTecnology\ControllerBasicsExtension\Services\RelationshipService;

abstract class Service
{
    use HandlesWithDependencies;

    // Services should implement these two methods to enable index()
    abstract protected function model();

    abstract protected function search();

    protected function includes(): array
    {
        return [];
    }

    protected function index(?string $search, ?array $filters = [])
    {
        if (null === $filters) {
            $filters = [];
        }

        if (null !== $search && '' !== $search && '0' !== $search) {
            $filters['byFilter,' . implode(';', $this->search())] = $search;
        }

        if (method_exists($this, 'filters') && $data = $this->handle('filters')) {
            $filters = array_merge($filters, $data);
        }

        $newFilters = [];

        foreach ($filters as $key => $value) {
            if (is_string($key) && str_starts_with($key, '(') && str_ends_with($key, ')')) {
                $newFilters[$key] = $value;

                continue;
            }

            $newFilters['(' . $key . ')'] = $value;
        }

        return app(BuilderQuery::class)->execute($this->model(), $this->includes(), $newFilters);
    }

    protected function store(array $data)
    {
        return app(RelationshipService::class)->execute($this->model(), $data);
    }

    protected function update(Model $model, array $data)
    {
        return app(RelationshipService::class)->execute($model, $data);
    }

    protected function delete($model): bool
    {
        return $model->delete();
    }
}
