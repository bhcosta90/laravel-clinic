<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Location;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class LocationService extends Service
{
    public function findByCode(string $code)
    {
        return app(BuilderQuery::class)->execute($this->model(), filters: [
            '(code)' => $code,
        ]);
    }

    protected function model(): Location
    {
        return new Location();
    }

    protected function search(): array
    {
        return ['name'];
    }
}
