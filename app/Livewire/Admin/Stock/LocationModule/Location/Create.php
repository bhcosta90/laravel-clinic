<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\LocationModule\Location;

use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Create extends Component
{
    use Alert;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.stock.location-module.location.create');
    }

    public function save(): void
    {
        $this->dispatch('created');

        $this->success();
    }
}
