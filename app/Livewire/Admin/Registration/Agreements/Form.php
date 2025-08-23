<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Agreements;

use App\Models\Agreement;
use App\Services\AgreementService;
use Illuminate\Validation\Rule;

final class Form extends \Livewire\Form
{
    public ?Agreement $model = null;

    public $name;
    public $cellphone;
    public $commission;

    public function setModel(Agreement $model): void
    {
        $this->model      = $model;
        $this->name       = $model->name;
        $this->cellphone  = $model->cellphone;
        $this->commission = $model->commission;
    }

    public function save(): Agreement
    {
        $data = $this->validate();

        if ($this->model?->id) {
            app(AgreementService::class)->handle('update', $this->model, $data);

            return $this->model;
        }

        return app(AgreementService::class)->handle('store', $data);
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:255'],
            'cellphone'  => ['required', 'string', 'max:150'],
            'commission' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
