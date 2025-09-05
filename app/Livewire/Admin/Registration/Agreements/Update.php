<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Agreements;

use App\Livewire\Traits\Alert;
use App\Models\Agreement;
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
        return view('livewire.admin.registration.agreements.update');
    }

    #[On('load::agreement')]
    public function load(Agreement $agreement): void
    {
        $this->form->setModel($agreement);
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
