<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\LocationModule\Location;

use App\Models\LocationModule;
use App\Services\LocationService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

final class Index extends Component
{
    use WithPagination;

    public LocationModule $locationModule;

    #[Url]
    public ?int $quantity = 15;

    #[Url]
    public ?string $search = null;

    #[Url]
    public array $sort = [
        'column'    => 'sequence',
        'direction' => 'asc',
    ];

    public function mount(): void
    {
        $this->locationModule = LocationModule::findOrFail(LocationModule::decodeHashCode(request()->route('module_location_hash')));
    }

    #[Computed(persist: true)]
    public function headers(): array
    {
        return [
            ['index' => 'sector.name', 'label' => __('Sector')],
            ['index' => 'code', 'label' => __('Location')],
            ['index' => 'sequence', 'label' => __('Sequence')],
            ['index' => 'status', 'label' => __('Status')],
            ['index' => 'type', 'label' => __('Address Type')],
            ['index' => 'created_at', 'label' => __('Created')],
            ['index' => 'action', 'sortable' => false],
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.stock.location-module.location.index');
    }

    #[Computed]
    public function rows(): Paginator
    {
        return app(LocationService::class)->handle('index', $this->search, [
            '(location_module_id)' => $this->locationModule->id,
        ])
            ->orderBy(...array_values($this->sort))
            ->simplePaginate(perPage: $this->quantity)
            ->withQueryString();
    }
}
