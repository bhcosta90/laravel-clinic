<?php

declare(strict_types=1);

namespace App\Livewire\Admin\People\Customers;

use App\Livewire\Traits\Alert;
use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Update extends Component
{
    use Alert;

    public Form $form;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.people.customers.update');
    }

    #[On('load::customer')]
    public function load(Customer $customer): void
    {
        $this->form->setModel($customer);

        $this->modal = true;
    }

    public function save(): void
    {
        $this->form->save();

        $this->dispatch('updated');

        $this->resetExcept('form');

        $this->success();
    }
}
