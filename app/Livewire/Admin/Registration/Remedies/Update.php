<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Remedies;

use App\Livewire\Traits\Alert;
use App\Models\Remedy;
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
        return view('livewire.admin.registration.remedies.update');
    }

    #[On('load::remedy')]
    public function load(Remedy $remedy): void
    {
        $this->form->setModel($remedy);
        $this->modal = true;
    }

    public function save(): void
    {
        $model = $this->form->save();

        $this->dispatch('updated');

        $this->form->setModel($model);

        $this->success();
    }
}
