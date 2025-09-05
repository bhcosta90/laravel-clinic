<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Catalog\Ean;

use App\Abstracts\Model;
use App\Enums\Models\Catalog\Hazardous;
use App\Enums\Models\Catalog\Status;
use App\Enums\Models\Catalog\TrackingMode;
use App\Models\Ean;
use App\Services\EanService;
use Illuminate\Validation\Rule;

final class Form extends \Livewire\Form
{
    public ?Ean $model           = null;
    public ?Model $modelRelation = null;

    public $unit_of_measure;
    public $ean;
    public $gross_weight;
    public $net_weight;

    public function setModelRelation(Model $modelRelation): void
    {
        $this->modelRelation = $modelRelation;
    }

    public function setModel(Ean $model): void
    {
        $this->model           = $model;
        $this->ean             = $model->ean;
        $this->gross_weight    = $model->gross_weight;
        $this->net_weight      = $model->net_weight;
        $this->unit_of_measure = $model->unit_of_measure;
    }

    public function save(): Ean
    {
        $data = $this->validate();

        if ($this->model?->id) {
            app(EanService::class)->handle('update', $this->model, $data);

            return $this->model;
        }

        return app(EanService::class)->handle('store', $data);
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
