<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\PaymentMethods;

use App\Livewire\Traits\Alert;
use App\Models\PaymentMethod;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Update extends Component
{
    use Alert;

    public ?PaymentMethod $payment = null;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.registration.payment-methods.update');
    }

    #[On('load::payment')]
    public function load(PaymentMethod $payment): void
    {
        $this->payment = $payment;

        $this->modal = true;
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

        $this->dispatch('updated');

        $this->resetExcept('payment');

        $this->success();
    }
}
