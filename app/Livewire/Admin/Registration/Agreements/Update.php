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

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.registration.agreements.update');
    }

    #[On('load::agreement')]
    public function load(Agreement $agreement): void
    {
        $this->form->setModel($agreement);
        $this->modal = true;
    }

    public function save(): void
    {
        $model = $this->form->save();

        $this->dispatch('updated');

        // Keep the form with current model values for UX; only close modal via external event if desired
        $this->form->setModel($model);

        $this->success();
    }
}
