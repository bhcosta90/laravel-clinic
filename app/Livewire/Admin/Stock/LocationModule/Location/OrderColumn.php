<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\LocationModule\Location;

use App\Jobs\LocationModule\OrderColumnJob;
use App\Livewire\Traits\Alert;
use App\Models\LocationModule;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class OrderColumn extends Component
{
    use Alert;

    public LocationModule $locationModule;

    public function render(): View
    {
        return view('livewire.admin.stock.location-module.location.order-column');
    }

    public function confirm(string $type): void
    {
        $this->question(description: __('Are you sure you want to order this block module again?'))
            ->confirm(method: 'order')
            ->cancel()
            ->send();

        dispatch(new OrderColumnJob($this->locationModule->id, $type));
    }
}
