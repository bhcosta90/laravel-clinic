<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Frequencies;

use App\Livewire\Traits\Alert;
use App\Models\Frequency;
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
        return view('livewire.admin.registration.frequencies.update');
    }

    #[On('load::frequency')]
    public function load(Frequency $frequency): void
    {
        $this->form->setModel($frequency);
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
