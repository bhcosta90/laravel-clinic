<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Triage;

use App\Livewire\Traits\Alert;
use App\Models\Triage;
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
        return view('livewire.admin.registration.triage.update');
    }

    #[On('load::triage')]
    public function load(Triage $triage): void
    {
        $this->form->setModel($triage);
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
