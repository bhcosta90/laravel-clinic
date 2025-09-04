<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Enums\Models\Location as LocationEnum;
use App\Jobs\Location\CreateBatchLocationJob;
use App\Models\Location;
use App\Models\LocationModule;
use DB;
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

    public function dataValidate(): array
    {
        return [
            'location_module_id' => ['required', 'numeric'],
            'sector_id'          => ['required', 'numeric'],
            'code'               => ['required', 'string', 'max:255', 'string'],
            'type'               => ['required', Rule::enum(LocationEnum\Type::class)],
            'aisle'              => ['nullable', 'string', 'max:4000000000'],
            'column'             => ['nullable', 'numeric', 'max:4000000000'],
            'level'              => ['nullable', 'numeric', 'max:4000000000'],
            'position'           => ['nullable', 'numeric', 'max:4000000000'],
            'zone'               => ['required', Rule::enum(LocationEnum\Zone::class)],
            'max_capacity'       => ['nullable', 'numeric', 'max:4000000000'],
            'sequence'           => ['nullable', 'numeric', 'max:4000000000'],
            'control'            => ['nullable', Rule::enum(LocationEnum\Control::class)],
            'temperature'        => ['nullable', 'numeric'],
            'status'             => ['required', Rule::enum(LocationEnum\Status::class)],
        ];
    }

    public function storeWithBuck(array $data): void
    {
        $data['column_initial'] ??= 1;
        $data['level_initial'] ??= 1;
        $data['position_initial'] ??= 1;

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
            'location_module_id' => ['required', 'numeric'],
            'column_initial'     => ['required', 'numeric', 'min:0'],
            'column_final'       => ['required', 'numeric', 'min:' . $data['column_initial'], 'max:' . $data['column_max']],
            'level_initial'      => ['required', 'numeric', 'min:0'],
            'level_final'        => ['required', 'numeric', 'min:' . $data['level_initial'], 'max:' . $data['level_max']],
            'position_initial'   => ['required', 'numeric', 'min:0'],
            'position_final'     => ['required', 'numeric', 'min:' . $data['position_initial'], 'max:' . $data['position_max']],
        ] + Arr::except($this->dataValidate(), [
            'code',
            'aisle',
            'column',
            'level',
            'position',
        ]));

        $total = optional($this->getLastSequence($data['location_module_id']))->sequence ?? 0;

        if ($total > 0) {
            $total += 10;
        }

        dispatch(new CreateBatchLocationJob($total, $data));
    }

    public function orderColumn(LocationModule $locationModule, string $type): void
    {
        $this->executeValidate(['type' => $type], [
            'type' => ['required', 'in:even_odd,odd_even,sequence'],
        ]);

        $query = app(BuilderQuery::class)->execute($this->model(), [
            '(location_module_id)' => $locationModule->id,
        ]);

        // Normalize type
        $type = mb_strtolower($type);

        // Define ordering according to requested mode
        // Also consider level and position as tie-breakers
        match ($type) {
            // Evens first (ASC), then odds (DESC within their group)
            // Use CASE expressions to apply different directions per parity
            'even_odd' => $query->orderByRaw('(`column` % 2) ASC')
                ->orderByRaw('CASE WHEN (`column` % 2) = 0 THEN `column` END ASC')
                ->orderByRaw('CASE WHEN (`column` % 2) = 1 THEN `column` END DESC')
                ->orderBy('level', 'ASC')
                ->orderBy('position', 'ASC')
                ->orderBy('id', 'ASC'),
            // Odds first (ASC), then evens (DESC within their group)
            'odd_even' => $query->orderByRaw('(`column` % 2) DESC')
                ->orderByRaw('CASE WHEN (`column` % 2) = 1 THEN `column` END ASC')
                ->orderByRaw('CASE WHEN (`column` % 2) = 0 THEN `column` END DESC')
                ->orderBy('level', 'ASC')
                ->orderBy('position', 'ASC')
                ->orderBy('id', 'ASC'),
            // Natural ascending sequence by column, then level and position
            default => $query->orderBy('column', 'ASC')
                ->orderBy('level', 'ASC')
                ->orderBy('position', 'ASC')
                ->orderBy('id', 'ASC'),
        };

        // Apply the computed order into sequence field so that the picking route is persisted
        $sequence = 0;
        $query->chunkById(500, function ($locations) use (&$sequence): void {
            foreach ($locations as $loc) {
                // Update only if different to minimize writes
                if ($loc->sequence !== $sequence) {
                    $loc->sequence = $sequence;
                    $loc->save();
                }
                ++$sequence;
            }
        }, 'id');

        $query->update([
            'sequence' => DB::raw('`sequence` * 10'),
        ]);
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

    private function getLastSequence(int $locationModuleId): ?Location
    {
        return app(BuilderQuery::class)->execute($this->model(), [
            '(location_module_id)' => $locationModuleId,
        ])->orderBy('sequence', 'desc')->first();
    }
}
