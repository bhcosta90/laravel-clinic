<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\LocationModule\Location;

use App\Enums\Models\Location\Control;
use App\Enums\Models\Location\Status;
use App\Enums\Models\Location\Type;
use App\Enums\Models\Location\Zone;
use App\Livewire\Traits\Alert;
use App\Models\LocationModule;
use App\Models\Sector;
use App\Services\LocationService;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

final class Create extends Component
{
    use Alert;

    public LocationModule $locationModule;

    public bool $modal = false;

    public $sector_id;
    public $temperatura;
    public $column_initial;
    public $column_final;
    public $level_initial;
    public $level_final;
    public $position_initial;
    public $position_final;
    public $type;
    public $control;
    public $zone;
    public $status;
    public $temperature;

    public function render(): View
    {
        return view('livewire.admin.stock.location-module.location.create');
    }

    public function save(): void
    {
        $this->dispatch('created');

        $data = $this->validate() + ['location_module_id' => $this->locationModule->id];

        app(LocationService::class)->handle('storeWithBuck', $data);

        $this->resetExcept('locationModule');

        $this->success();

        $this->dialog()->success(__('Address registration sent to the system, wait a few moments to be able to see it complete here'))->send();
    }

    protected function rules(): array
    {
        return [
            'sector_id'        => ['required', 'numeric', Rule::exists(Sector::class, 'id')->where('tenant_id', tenant()->id)],
            'column_initial'   => ['required', 'numeric', 'min:0'],
            'column_final'     => ['required', 'numeric', 'min:0'],
            'level_initial'    => ['required', 'numeric', 'min:0'],
            'level_final'      => ['required', 'numeric', 'min:0'],
            'position_initial' => ['required', 'numeric', 'min:0'],
            'position_final'   => ['required', 'numeric', 'min:0'],
            'type'             => ['required', Rule::enum(Type::class)],
            'zone'             => ['required', Rule::enum(Zone::class)],
            'control'          => ['nullable', Rule::enum(Control::class)],
            'temperature'      => ['nullable', 'numeric'],
            'status'           => ['required', Rule::enum(Status::class)],
        ];
    }
}
