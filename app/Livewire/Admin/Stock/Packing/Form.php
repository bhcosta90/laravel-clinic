<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Packing;

use App\Enums\Models\Packing\Level;
use App\Models\Packing;
use App\Services\PackingService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

final class Form extends \Livewire\Form
{
    public ?Model $relation = null;
    public ?Packing $model  = null;

    public $level;
    public $quantity;
    public $weight;
    public $length;
    public $width;
    public $height;

    public function setRelation(Model $relation): void
    {
        $this->relation = $relation;
    }

    public function setModel(Packing $model): void
    {
        $this->model    = $model;
        $this->level    = $model->level;
        $this->quantity = $model->quantity;
        $this->weight   = $model->weight;
        $this->length   = $model->length;
        $this->width    = $model->width;
        $this->height   = $model->height;
    }

    public function save(): Packing
    {
        $data = $this->validate();

        if ($this->model?->id) {
            app(PackingService::class)->handle('update', $this->model, $data);

            return $this->model;
        }

        $keyName = $this->relation->getKeyName();

        $data += [
            'model_type' => $this->relation::class,
            'model_id'   => $this->relation->{$keyName},
        ];

        return app(PackingService::class)->handle('store', $data);
    }

    public function rules(): array
    {
        return [
            'level'    => ['required', Rule::enum(Level::class)],
            'quantity' => ['required', 'integer', 'min:1'],
            'weight'   => ['required', 'numeric', 'min:0'],
            'length'   => ['required', 'numeric', 'min:0'],
            'width'    => ['required', 'numeric', 'min:0'],
            'height'   => ['required', 'numeric', 'min:0'],
        ];
    }
}
