<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Financial\Transactions\ReceiptAgreement;

use App\Enums\Models\Transaction\Type;
use App\Models\Agreement;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Validation\Rule;

final class Form extends \Livewire\Form
{
    public ?Transaction $model = null;

    public $date_start;
    public $date_end;
    public $agreement_id;
    public $payment_method_id;
    public $value;
    public $description;

    public function save(): void
    {
        $data = $this->validate();

        $agreement = Agreement::find($data['agreement_id']);

        app(TransactionService::class)->handle('store', [
            'name'              => $agreement->name . " ({$data['date_start']} - {$data['date_end']})",
            'user_id'           => null,
            'agreement_id'      => $data['agreement_id'],
            'customer_id'       => null,
            'payment_method_id' => $data['payment_method_id'],
            'value'             => (float) $data['value'],
            'description'       => $data['description'] ?? null,
            'due_date'          => now(),
            'payment_date'      => null,
            'type'              => Type::Incomes,
        ]);
    }

    public function rules(): array
    {
        return [
            'date_start'        => ['required', 'date_format:Y-m-d'],
            'date_end'          => ['required', 'date_format:Y-m-d'],
            'agreement_id'      => ['required', Rule::exists(Agreement::class, 'id')],
            'payment_method_id' => ['required', Rule::exists(PaymentMethod::class, 'id')],
            'value'             => ['required', 'numeric', 'min:0'],
            'description'       => ['nullable', 'string', 'max:255'],
        ];
    }
}
