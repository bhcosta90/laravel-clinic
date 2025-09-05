<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\AnamnesisItem;

use App\Livewire\Traits\Alert;
use App\Models\AnamnesisItem;
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
        return view('livewire.admin.registration.anamnesis-item.update');
    }

    #[On('load::anamnesisItem')]
    public function load(AnamnesisItem $anamnesisItem): void
    {
        $this->form->setModel($anamnesisItem);
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
