<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Catalog;

use App\Livewire\Traits\Alert;
use App\Models\Catalog;
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
        return view('livewire.admin.stock.catalog.update');
    }

    #[On('load::catalog')]
    public function load(Catalog $catalog): void
    {
        $this->form->setModel($catalog);

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
