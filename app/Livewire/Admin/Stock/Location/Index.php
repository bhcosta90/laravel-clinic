<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Location;

use App\Services\LocationService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use QuantumTecnology\ControllerBasicsExtension\Enum\QueryBuilderType;

final class Index extends Component
{
    use WithPagination;

    #[Url]
    public ?int $quantity = 15;

    #[Url]
    public ?string $search = null;

    #[Url]
    public array $sort = [
        'column'    => 'sequence',
        'direction' => 'asc',
    ];

    #[Computed(persist: true)]
    public function headers(): array
    {
        return [
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
        return view('livewire.admin.stock.location.index');
    }

    #[Computed]
    public function rows(): Paginator
    {
        return app(LocationService::class)->handle('index', $this->search, [
            '(location_module_id)' => QueryBuilderType::Null,
        ])
            ->orderBy(...array_values($this->sort))
            ->simplePaginate(perPage: $this->quantity)
            ->withQueryString();
    }
}
