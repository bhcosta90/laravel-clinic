<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\LocationModule;

use App\Models\LocationModule;
use App\Services\LocationModuleService;
use Illuminate\Validation\Rule;

final class Form extends \Livewire\Form
{
    public ?LocationModule $model = null;

    public $acronym;
    public $sequence;

    public function setModel(LocationModule $model): void
    {
        $this->model    = $model;
        $this->acronym  = $model->acronym;
        $this->sequence = $model->sequence;
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
            'acronym' => [
                'required',
                'string',
                'max:255',
                Rule::exists(LocationModule::class)->where('tenant_id', tenant()->id),
            ],
            'sequence' => ['nullable', 'numeric', 'max:4000000000'],
        ];
    }
}
