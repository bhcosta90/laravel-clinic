<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Catalog;

use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Create extends Component
{
    use Alert;

    public Form $form;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.stock.catalog.create');
    }

    public function save(): void
    {
        $this->form->save();

        $this->dispatch('created');

        $this->modal = false;

        $this->success();
    }
}
