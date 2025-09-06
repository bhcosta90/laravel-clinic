<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Packing;

use App\Models\Packing;
use App\Services\PackingService;

final class Form extends \Livewire\Form
{
    public ?Packing $model = null;

    public $level;
    public $quantity;
    public $weight;
    public $length;
    public $width;
    public $height;

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

        return app(PackingService::class)->handle('store', $data);
    }

    public function rules(): array
    {
        return [
            'name' => ['required',  'string',  'max:240'],
        ];
    }
}
