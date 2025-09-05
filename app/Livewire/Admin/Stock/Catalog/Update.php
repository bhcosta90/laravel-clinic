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

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.stock.catalog.update');
    }

    #[On('load::catalog')]
    public function load(Catalog $catalog): void
    {
        $this->form->setModel($catalog);
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
