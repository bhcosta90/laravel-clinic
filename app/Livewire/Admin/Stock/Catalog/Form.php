<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Catalog;

use App\Enums\Models\Catalog\Hazardous;
use App\Enums\Models\Catalog\Status;
use App\Enums\Models\Catalog\TrackingMode;
use App\Models\Catalog;
use App\Services\CatalogService;
use Illuminate\Validation\Rule;

final class Form extends \Livewire\Form
{
    public ?Catalog $model = null;

    public $name;
    public $hazardous;
    public $status;
    public $tracking_mode;

    public function setModel(Catalog $model): void
    {
        $this->model         = $model;
        $this->name          = $model->name;
        $this->hazardous     = $model->hazardous;
        $this->status        = $model->status;
        $this->tracking_mode = $model->tracking_mode;
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
            'name'          => ['required', 'string', 'max:255'],
            'status'        => ['required', Rule::enum(Status::class)],
            'hazardous'     => ['required', Rule::enum(Hazardous::class)],
            'tracking_mode' => ['required', Rule::enum(TrackingMode::class)],
        ];
    }
}
