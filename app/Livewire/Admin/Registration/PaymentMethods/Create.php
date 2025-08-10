<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Registration\PaymentMethods;

use App\Livewire\Traits\Alert;
use App\Models\PaymentMethod;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Create extends Component
{
    use Alert;

    public PaymentMethod $payment;

    public bool $modal = false;

    public function mount(): void
    {
        $this->payment = new PaymentMethod();
    }

    public function render(): View
    {
        return view('livewire.admin.registration.payment-methods.create');
    }

    public function rules(): array
    {
        return [
            'payment.name' => ['required', 'string', 'max:255'],
            'payment.tax'  => ['required', 'numeric:', 'min:0', 'max:100'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->payment->save();

        $this->dispatch('created');

        $this->reset();
        $this->payment = new PaymentMethod();

        $this->success();
    }
}
