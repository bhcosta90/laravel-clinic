<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Catalog;

use App\Enums\Models\Catalog\Hazardous;
use App\Enums\Models\Catalog\Level;
use App\Enums\Models\Catalog\Status;
use App\Enums\Models\Catalog\TrackingMode;
use App\Models\Catalog;
use App\Rules\TenantUnique;
use App\Services\CatalogService;
use Illuminate\Validation\Rule;

final class Form extends \Livewire\Form
{
    public ?Catalog $model = null;

    public $name;
    public $sku_code;
    public $level;
    public $tracking_mode;
    public $hazardous;
    public $status;

    public function setModel(Catalog $model): void
    {
        $this->model         = $model;
        $this->name          = $model->name;
        $this->sku_code      = $model->sku_code;
        $this->level         = $model->level;
        $this->tracking_mode = $model->tracking_mode;
        $this->hazardous     = $model->hazardous;
        $this->status        = $model->status;
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
            'name'          => ['required', 'string', 'max:240'],
            'sku_code'      => ['required', 'string', 'max:100', new TenantUnique(Catalog::class, 'sku_code', $this->model?->id)],
            'level'         => ['required', Rule::enum(Level::class)],
            'tracking_mode' => ['required', Rule::enum(TrackingMode::class)],
            'hazardous'     => ['nullable', Rule::enum(Hazardous::class)],
            'status'        => ['required', Rule::enum(Status::class)],
        ];
    }
}
