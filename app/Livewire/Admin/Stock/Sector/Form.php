<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Sector;

use App\Models\Sector;
use App\Services\SectorService;

final class Form extends \Livewire\Form
{
    public ?Sector $model = null;

    public $name;

    public function setModel(Sector $model): void
    {
        $this->model = $model;
        $this->name  = $model->name;
    }

    public function save(): Sector
    {
        $data = $this->validate();

        if ($this->model?->id) {
            app(SectorService::class)->handle('update', $this->model, $data);

            return $this->model;
        }

        return app(SectorService::class)->handle('store', $data);
    }

    public function rules(): array
    {
        return [
            'name' => ['required',  'string',  'max:255'],
        ];
    }
}
