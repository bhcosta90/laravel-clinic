<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Enums\Models\Location as LocationEnum;
use App\Models\Location;
use Illuminate\Validation\Rule;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class LocationService extends Service
{
    public function findByCode(string $code)
    {
        return app(BuilderQuery::class)->execute($this->model(), filters: [
            '(code)' => $code,
        ]);
    }

    protected function dataValidate(): array
    {
        return [
            'type'             => ['required', Rule::enum(LocationEnum\Type::class)],
            'aisle'            => ['nullable', 'string', 'max:10'],
            'column'           => ['nullable', 'string', 'max:10'],
            'level'            => ['nullable', 'string', 'max:10'],
            'position'         => ['nullable', 'string', 'max:10'],
            'zone'             => ['required', Rule::enum(LocationEnum\Zone::class)],
            'location_type'    => ['required', Rule::enum(LocationEnum\Zone::class)],
            'max_capacity'     => ['nullable', 'numeric', 'max:4000000000'],
            'picking_sequence' => ['nullable', 'numeric', 'max:4000000000'],
            'control'          => ['required', Rule::enum(LocationEnum\Control::class)],
            'temperature'      => ['nullable', 'numeric'],
            'status'           => ['required', Rule::enum(LocationEnum\Status::class)],
        ];
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
