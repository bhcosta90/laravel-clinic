<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Enums\Models\Location as LocationEnum;
use App\Models\Location;
use App\Models\Sector;
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

    public function dataValidate(array $data): array
    {
        return [
            'sector_id' => [
                'required',
                Rule::exists(Sector::class, 'id')
                    ->where('tenant_id', tenant()->id),
            ],
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique(Location::class)
                    ->where('tenant_id', tenant()->id)
                    ->ignore($data['id'] ?? null),
            ],
            'type'         => ['required', Rule::enum(LocationEnum\Type::class)],
            'aisle'        => ['nullable', 'numeric', 'max:4000000000'],
            'column'       => ['nullable', 'numeric', 'max:4000000000'],
            'level'        => ['nullable', 'numeric', 'max:4000000000'],
            'position'     => ['nullable', 'numeric', 'max:4000000000'],
            'zone'         => ['required', Rule::enum(LocationEnum\Zone::class)],
            'max_capacity' => ['nullable', 'numeric', 'max:4000000000'],
            'sequence'     => ['nullable', 'numeric', 'max:4000000000'],
            'control'      => ['nullable', Rule::enum(LocationEnum\Control::class)],
            'temperature'  => ['nullable', 'numeric'],
            'status'       => ['required', Rule::enum(LocationEnum\Status::class)],
        ];
    }

    protected function includes(): array
    {
        return [
            'sector' => ['id'],
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
