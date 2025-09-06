<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Catalog\Ean;

use App\Abstracts\Model;
use App\Enums\Models\Packing\Level;
use App\Models\Ean;
use App\Rules\TenantUnique;
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
    public $volume;
    public $conversion_factor;

    public function setModelRelation(Model $modelRelation): void
    {
        $this->modelRelation = $modelRelation;
    }

    public function setModel(Ean $model): void
    {
        $this->model             = $model;
        $this->ean               = $model->ean;
        $this->gross_weight      = $model->gross_weight;
        $this->net_weight        = $model->net_weight;
        $this->unit_of_measure   = $model->unit_of_measure;
        $this->volume            = $model->volume;
        $this->conversion_factor = $model->conversion_factor;
    }

    public function save(): Ean
    {
        $data = $this->validate();

        if ($this->model?->id) {
            app(EanService::class)->handle('update', $this->model, $data);

            return $this->model;
        }

        return app(EanService::class)->handle('store', $data + [
            'model_id'   => $this->modelRelation->id,
            'model_type' => $this->modelRelation instanceof Model ? $this->modelRelation::class : self::class,
        ]);
    }

    public function rules(): array
    {
        return [
            'ean'               => ['required', 'string', 'max:255', new TenantUnique(Ean::class, 'ean', $this->model?->id)],
            'gross_weight'      => ['nullable', 'numeric', 'min:0'],
            'net_weight'        => ['nullable', 'numeric', 'min:0'],
            'unit_of_measure'   => ['required', 'integer', Rule::enum(Level::class)],
            'volume'            => ['nullable', 'numeric', 'min:0'],
            'conversion_factor' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
