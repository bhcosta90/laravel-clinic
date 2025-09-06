<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Financial\Transactions;

use App\Enums\Models\Transaction\Type;
use App\Models\Agreement;
use App\Models\Customer;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\User;
use App\Services\TransactionService;
use Illuminate\Validation\Rule;

final class Form extends \Livewire\Form
{
    public ?Transaction $model = null;

    public $name;
    public $user_id;
    public $agreement_id;
    public $customer_id;
    public $payment_method_id;
    public $value;
    public $description;
    public $due_date;
    public $payment_date;
    public $type;

    public function setModel(Transaction $model): void
    {
        $this->model             = $model;
        $this->name              = $model->name;
        $this->user_id           = $model->user_id;
        $this->agreement_id      = $model->agreement_id;
        $this->customer_id       = $model->customer_id;
        $this->payment_method_id = $model->payment_method_id;
        $this->value             = $model->value;
        $this->description       = $model->description;
        $this->due_date          = $model->due_date;
        $this->payment_date      = $model->payment_date;
        $this->type              = $model->type;
    }

    public function save(): void
    {
        $data = $this->validate();

        if ($this->model?->id) {
            app(TransactionService::class)->handle('update', $this->model, $data);

            return;
        }

        app(TransactionService::class)->handle('store', $data);
    }

    public function rules(): array
    {
        return [
            'name'              => ['required', 'string', 'max:240'],
            'user_id'           => ['nullable', Rule::exists(User::class, 'id')],
            'agreement_id'      => ['nullable', Rule::exists(Agreement::class, 'id')],
            'customer_id'       => ['nullable', Rule::exists(Customer::class, 'id')],
            'payment_method_id' => ['required', Rule::exists(PaymentMethod::class, 'id')],
            'value'             => ['required', 'numeric', 'min:0'],
            'description'       => ['nullable', 'string', 'max:240'],
            'type'              => ['required', Rule::enum(Type::class)],
            'due_date'          => ['required', 'date', 'after_or_equal:today'],
            'payment_date'      => ['nullable', 'date', 'after_or_equal:today'],
        ];
    }
}
