<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Catalog;

use App\Livewire\Traits\Alert;
use App\Models\Catalog;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Update extends Component
{
    use Alert;

    public Form $form;

    public function render(): View
    {
        return view('livewire.admin.stock.catalog.update');
    }

    public function mount(): void
    {
        $this->form->setModel(Catalog::findOrFail(Catalog::decodeHashCode(request()->route('catalog_hash'))));
    }

    public function save(): void
    {
        $this->form->save();

        $this->success();
    }
}
