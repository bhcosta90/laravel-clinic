<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\People\Customers;

use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Create extends Component
{
    use Alert;

    public Form $form;

    public bool $modal = false;

    public bool $showButton = true;

    public function render(): View
    {
        return view('livewire.admin.people.customers.create');
    }

    public function save(): void
    {
        $customer = $this->form->save();

        $this->dispatch('created');
        $this->dispatch('customer::created', $customer->id);

        $this->resetExcept('form', 'showButton');
        $this->form->reset();

        $this->success();
    }

    #[On('customer::open')]
    public function open(): void
    {
        $this->modal = true;
    }
}
