<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Sector;

use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Create extends Component
{
    use Alert;

    public Form $form;

    public bool $slide = false;

    public bool $showButton = true;

    public function render(): View
    {
        return view('livewire.admin.stock.sector.create');
    }

    public function save(): void
    {
        $sector = $this->form->save();

        $this->dispatch('created');
        $this->dispatch('sector::created', $sector->id);

        $this->resetExcept('form', 'showButton');
        $this->form->reset();

        $this->success();
    }

    #[On('sector::open')]
    public function open(): void
    {
        $this->slide = true;
    }
}
