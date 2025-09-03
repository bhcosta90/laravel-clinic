<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\LocationModule;

use App\Models\LocationModule;
use App\Services\LocationModuleService;

final class Form extends \Livewire\Form
{
    public ?LocationModule $model = null;

    public $name;
    public $days;

    public function setModel(LocationModule $model): void
    {
        $this->model = $model;
        $this->name  = $model->name;
        $this->days  = $model->days;
    }

    public function save(): LocationModule
    {
        $data = $this->validate();

        if ($this->model?->id) {
            app(LocationModuleService::class)->handle('update', $this->model, $data);

            return $this->model;
        }

        return app(LocationModuleService::class)->handle('store', $data);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'days' => ['required', 'numeric', 'min:0'],
        ];
    }
}
