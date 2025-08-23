<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Procedures;

use App\Livewire\Traits\Alert;
use App\Models\Procedure;
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
        return view('livewire.admin.registration.procedures.update');
    }

    #[On('load::procedure')]
    public function load(Procedure $procedure): void
    {
        $this->form->setModel($procedure);
        $this->modal = true;
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
