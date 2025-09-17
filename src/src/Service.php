<?php

declare(strict_types = 1);

namespace Costa\Service;

use Costa\Service\Traits\HandlesWithDependencies;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;
use QuantumTecnology\ControllerBasicsExtension\Services\RelationshipService;

abstract class Service
{
    use HandlesWithDependencies;

    abstract protected function model();

    abstract protected function search(): array;

    final public function index(?string $search = null, ?array $filters = [])
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

        return app(BuilderQuery::class)->execute($this->model(), $this->includes(), [], $newFilters);
    }

    final public function store(array $data): Model
    {
        $this->validateMethod('storeValidate', $data);
        $this->validateMethod('dataValidate', $data);
        $data = $this->serializeData($data);

        return app(RelationshipService::class)->execute($this->model(), $data);
    }

    final public function update(Model $model, array $data): Model
    {
        $keyName  = $model->getKeyName();
        $keyValue = $model->{$keyName};

        $data[$keyName] = $keyValue;
        $this->validateMethod('updateValidate', $data);
        $this->validateMethod('dataValidate', $data);

        unset($data[$keyName]);

        $data = $this->serializeData($data);

        return app(RelationshipService::class)->execute($model, $data);
    }

    final public function delete($model): bool
    {
        return $model->delete();
    }

    protected function includes(): array
    {
        return [];
    }

    protected function executeValidate(array $data, array $rules): array
    {
        return Validator::make($data, $rules)->validate();
    }

    protected function validateMethod(string $method, array &$data): void
    {
        if (method_exists($this, $method)) {
            $rules = $this->handle($method, $data);
            $data  = $this->executeValidate($data, $rules);
        }
    }

    protected function serializeData(array $data): array
    {
        return $data;
    }
}
