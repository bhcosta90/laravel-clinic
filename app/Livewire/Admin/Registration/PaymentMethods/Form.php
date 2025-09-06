<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\PaymentMethods;

use App\Models\PaymentMethod;
use App\Services\PaymentMethodService;

final class Form extends \Livewire\Form
{
    public ?PaymentMethod $model = null;

    public $name;
    public $tax;

    public function setModel(PaymentMethod $model): void
    {
        $this->model = $model;
        $this->name  = $model->name;
        $this->tax   = $model->tax;
    }

    public function save(): PaymentMethod
    {
        $data = $this->validate();

        if ($this->model?->id) {
            app(PaymentMethodService::class)->handle('update', $this->model, $data);

            return $this->model;
        }

        return app(PaymentMethodService::class)->handle('store', $data);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:240'],
            'tax'  => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
