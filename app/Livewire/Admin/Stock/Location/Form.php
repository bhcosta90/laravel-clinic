<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Location;

use App\Enums\Models\Location as LocationEnum;
use App\Models\Location;
use App\Services\LocationService;
use Illuminate\Validation\Rule;

final class Form extends \Livewire\Form
{
    public ?Location $model = null;

    public ?string $code            = null;
    public ?string $type            = null;
    public ?string $aisle           = null;
    public ?string $column          = null;
    public ?string $level           = null;
    public ?string $position        = null;
    public ?string $zone            = null;
    public ?string $location_type   = null;
    public ?float $max_capacity     = null;
    public ?float $picking_sequence = null;
    public ?string $control         = null;
    public ?float $temperature      = null;
    public ?string $status          = null;

    public function setModel(Location $model): void
    {
        $this->model            = $model;
        $this->code             = $model->code;
        $this->type             = $model->type;
        $this->aisle            = $model->aisle;
        $this->column           = $model->column;
        $this->level            = $model->level;
        $this->position         = $model->position;
        $this->zone             = $model->zone;
        $this->location_type    = $model->location_type;
        $this->max_capacity     = $model->max_capacity;
        $this->picking_sequence = $model->picking_sequence;
        $this->control          = $model->control;
        $this->temperature      = $model->temperature;
        $this->status           = $model->status;
    }

    public function save(): Location
    {
        $data = $this->validate();

        if ($this->model?->id) {
            app(LocationService::class)->handle('update', $this->model, $data);

            return $this->model;
        }

        return app(LocationService::class)->handle('store', $data);
    }

    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::exists(Location::class)->where('tenant_id', auth()->user()->tenant_id),
            ],
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
}
