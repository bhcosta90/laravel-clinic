<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Packing;

use App\Models\Packing;
use App\Services\PackingService;

final class Form extends \Livewire\Form
{
    public ?Packing $model = null;

    public $name;

    public function setModel(Packing $model): void
    {
        $this->model = $model;
        $this->name  = $model->name;
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
