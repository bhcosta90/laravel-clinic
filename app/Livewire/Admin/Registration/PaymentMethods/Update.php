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

    public Form $form;

    public bool $slide = false;

    public function render(): View
    {
        return view('livewire.admin.registration.payment-methods.update');
    }

    #[On('load::payment')]
    public function load(PaymentMethod $payment): void
    {
        $this->form->setModel($payment);
        $this->slide = true;
    }

    public function save(): void
    {
        $model = $this->form->save();

        $this->dispatch('updated');

        $this->form->setModel($model);

        $this->success();
        $this->resetExcept('form');
    }
}
