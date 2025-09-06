<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Catalog;

use App\Models\Catalog;
use App\Services\CatalogService;

final class Form extends \Livewire\Form
{
    public ?Catalog $model = null;

    public $name;
    public $sku_code;
    public $tracking_mode;
    public $hazardous;
    public $level;

    public function setModel(Catalog $model): void
    {
        $this->model = $model;
        $this->name  = $model->name;
    }

    public function save(): Catalog
    {
        $data = $this->validate();

        if ($this->model?->id) {
            app(CatalogService::class)->handle('update', $this->model, $data);

            return $this->model;
        }

        return app(CatalogService::class)->handle('store', $data);
    }

    public function rules(): array
    {
        return [
            'name' => ['required',  'string',  'max:255'],
        ];
    }
}
