<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Appointments\Appointments;

use App\Enums\Models\Transaction\Type;
use App\Jobs\Transaction\CreateTransactionJob;
use App\Livewire\Traits\Alert;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

final class ExecutePayment extends Component
{
    use Alert;

    public Appointment $appointment;

    public int $user_id;

    public float $value;

    public string $date;

    public ?int $payment_method_id = null;

    public ?int $agreement_id = null;

    public ?string $description = null;

    public bool $modal = false;

    public function mount(): void
    {
        $this->user_id = $this->appointment->user_id;
        $this->value   = $this->appointment->procedure->price;
        $this->date    = now()->format('Y-m-d');
    }

    public function render(): View
    {
        return view('livewire.admin.appointments.appointments.execute-payment');
    }

    public function save(): void
    {
        $this->validate();

        $this->appointment->is_paid = true;
        $this->appointment->save();

        dispatch(new CreateTransactionJob(
            name: $this->appointment->procedure->name,
            user_id: $this->user_id,
            agreement_id: $this->agreement_id,
            customer_id: $this->appointment->customer_id,
            payment_method_id: $this->payment_method_id,
            value: $this->value,
            description: $this->description,
            due_date: now()->parse($this->date),
            payment_date: now(),
            type: Type::Incomes,
            model: $this->appointment
        ));

        $this->reset();

        $this->success();

        $this->dispatch('updated');
    }

    protected function rules(): array
    {
        return [
            'value'             => ['required', 'min:0'],
            'user_id'           => ['required', Rule::exists(User::class, 'id')->where('is_employee', true)],
            'date'              => ['required', 'date', 'after_or_equal:today'],
            'payment_method_id' => ['nullable', Rule::exists('payment_methods', 'id')],
            'agreement_id'      => ['nullable', Rule::exists('agreements', 'id')],
            'description'       => ['nullable', 'string', 'max:255'],
        ];
    }
}
