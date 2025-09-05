<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Frequencies;

use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Create extends Component
{
    use Alert;

    public Form $form;

    public bool $slide = false;

    public function render(): View
    {
        return view('livewire.admin.registration.frequencies.create');
    }

    public function save(): void
    {
        $this->form->save();

        $this->dispatch('created');

        $this->form->reset();
        $this->resetExcept('form');

        $this->success();
    }
}
