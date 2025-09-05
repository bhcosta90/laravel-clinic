<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Sector;

use App\Livewire\Traits\Alert;
use App\Models\Sector;
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
        return view('livewire.admin.stock.sector.update');
    }

    #[On('load::sector')]
    public function load(Sector $sector): void
    {
        $this->form->setModel($sector);

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
