<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\LocationModule\Location;

use App\Livewire\Traits\Alert;
use App\Models\LocationModule;
use App\Services\LocationService;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class OrderColumn extends Component
{
    use Alert;

    public LocationModule $locationModule;

    public string $type;

    public function render(): View
    {
        return view('livewire.admin.stock.location-module.location.order-column');
    }

    public function confirm(string $type): void
    {
        $this->type = $type;

        $this->question(description: __('Are you sure you want to order this block module again?'))
            ->confirm(method: 'order')
            ->cancel()
            ->send();
    }

    public function order(): void
    {

        app(LocationService::class)->handle('orderColumn', $this->locationModule, $this->type);

        $this->dialog()->success(__('The module is being ordered again, please wait a few moments to see the result.'))->send();
    }
}
