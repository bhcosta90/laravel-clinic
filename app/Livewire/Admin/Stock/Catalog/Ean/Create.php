<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Catalog\Ean;

use App\Livewire\Traits\Alert;
use App\Models\Catalog;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Create extends Component
{
    use Alert;

    public Form $form;

    public Catalog $catalog;

    public bool $slide = false;

    public function render(): View
    {
        return view('livewire.admin.stock.catalog.ean.create');
    }

    public function save(): void
    {
        $this->form->setModelRelation($this->catalog);
        $this->form->save();

        $this->dispatch('created');

        $this->slide = false;

        $this->success();
    }
}
