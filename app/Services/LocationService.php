<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Enums\Models\Location as LocationEnum;
use App\Jobs\Location\CreateNewLocationJob;
use App\Models\Location;
use App\Models\LocationModule;
use App\Models\Sector;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Override;
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
            'aisle'        => ['nullable', 'string', 'max:4000000000'],
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

    public function storeWithBuck(array $data): void
    {
        $data['column_initial']   = $data['column_initial'] ?? 1;
        $data['level_initial']    = $data['level_initial'] ?? 1;
        $data['position_initial'] = $data['position_initial'] ?? 1;

        $limits = [
            'column'   => $data['column_initial'],
            'level'    => $data['level_initial'],
            'position' => $data['position_initial'],
        ];

        foreach ($limits as $key => $initial) {
            $maxKey        = $key . '_max';
            $data[$maxKey] = min($initial + 25, 4000000000);
        }

        $this->executeValidate($data, [
            'location_module_id' => [
                'required',
                Rule::exists(LocationModule::class, 'id')
                    ->where('tenant_id', tenant()->id),
            ],
            'column_initial'   => ['required', 'numeric', 'min:0'],
            'column_final'     => ['required', 'numeric', 'min:' . $data['column_initial'], 'max:' . $data['column_max']],
            'level_initial'    => ['required', 'numeric', 'min:0'],
            'level_final'      => ['required', 'numeric', 'min:' . $data['level_initial'], 'max:' . $data['level_max']],
            'position_initial' => ['required', 'numeric', 'min:0'],
            'position_final'   => ['required', 'numeric', 'min:' . $data['position_initial'], 'max:' . $data['position_max']],
        ] + Arr::except($this->dataValidate($data), [
            'code',
            'aisle',
            'column',
            'level',
            'position',
        ]));

        $total = $this->getLastSequence($data['location_module_id'])->sequence ?? 0;

        for ($i = $data['column_initial']; $i <= $data['column_final']; ++$i) {
            for ($j = $data['level_initial']; $j <= $data['level_final']; ++$j) {
                for ($k = $data['position_initial']; $k <= $data['position_final']; ++$k) {
                    dispatch(new CreateNewLocationJob(
                        $data['location_module_id'],
                        $data['sector_id'],
                        $data['type'],
                        $i,
                        $j,
                        $k,
                        $data['zone'],
                        $data['max_capacity'] ?? null,
                        $total,
                        $data['control'] ?? null,
                        $data['temperature'] ?? null,
                        $data['status'],
                    ));

                    $total += $i + $j + $k;
                }
            }
        }
    }

    protected function getLastSequence(int $locationModuleId): ?Location
    {
        return app(BuilderQuery::class)->execute($this->model(), [
            '(location_module_id)' => $locationModuleId,
        ])->orderBy('sequence', 'desc')->first();
    }

    #[Override]
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
