<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Financial\Commissions;

use App\Models\Commission;
use App\Models\User;
use App\Services\CommissionService;
use Illuminate\Validation\Rule;

final class Form extends \Livewire\Form
{
    public ?Commission $model = null;

    public $user_id;
    public $value;
    public $due_date;
    public $payment_date;

    public function setModel(Commission $model): void
    {
        $this->model        = $model;
        $this->user_id      = $model->user_id;
        $this->value        = $model->value;
        $this->due_date     = $model->due_date;
        $this->payment_date = $model->payment_date;
    }

    public function save(): Commission
    {
        $data = $this->validate();

        if ($this->model?->id) {
            app(CommissionService::class)->handle('update', $this->model, $data);

            return $this->model;
        }

        return app(CommissionService::class)->handle('store', $data);
    }

    public function rules(): array
    {
        return [
            'user_id'      => ['required', Rule::exists(User::class, 'id')->where('is_employee', true)],
            'value'        => ['required', 'numeric:', 'min:0'],
            'due_date'     => ['required', 'date', 'after_or_equal:today'],
            'payment_date' => ['nullable', 'date', 'after_or_equal:today'],
        ];
    }
}
