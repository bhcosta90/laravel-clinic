<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Catalog;

use App\Livewire\Traits\Alert;
use App\Models\Catalog;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Packing extends Component
{
    use Alert;

    public Catalog $catalog;

    public function render(): View
    {
        return view('livewire.admin.stock.catalog.packing');
    }

    public function mount(): void
    {
        $this->catalog = Catalog::findOrFail(Catalog::decodeHashCode(request()->route('catalog_hash')));
    }

    public function save(): void
    {
        $this->form->save();

        $this->success();
    }
}
