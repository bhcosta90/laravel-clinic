<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Catalog\Ean;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Update extends Component
{
    public bool $slide = false;

    public function render(): View
    {
        return view('livewire.admin.stock.catalog.ean.update');
    }
}
