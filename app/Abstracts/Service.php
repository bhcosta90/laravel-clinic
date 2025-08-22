<?php

declare(strict_types = 1);

namespace App\Abstracts;

use QuantumTecnology\ControllerBasicsExtension\Services\RelationshipService;

abstract class Service
{
    abstract protected function model();

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
