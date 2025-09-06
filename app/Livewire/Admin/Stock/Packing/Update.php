<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Packing;

use App\Livewire\Traits\Alert;
use App\Models\Packing;
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
        return view('livewire.admin.stock.packing.update');
    }

    #[On('load::packing')]
    public function load(Packing $packing): void
    {
        $this->form->setModel($packing);

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
