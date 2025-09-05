<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\People\Employees;

use App\Livewire\Traits\Alert;
use App\Models\User;
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
        return view('livewire.admin.people.employees.update');
    }

    #[On('load::employee')]
    public function load(User $employee): void
    {
        $this->form->setModel($employee);
        $this->slide = true;
    }

    public function save(): void
    {
        $this->form->save();

        $this->dispatch('updated');

        $this->resetExcept('form');

        $this->success();
    }
}
