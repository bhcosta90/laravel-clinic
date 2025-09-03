<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\LocationModule;

use App\Services\LocationModuleService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

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
            ['index' => 'acronym', 'label' => __('Acronym')],
            ['index' => 'sequence', 'label' => __('Sequence')],
            ['index' => 'created_at', 'label' => __('Created')],
            ['index' => 'action', 'sortable' => false],
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.stock.location-module.index');
    }

    #[Computed]
    public function rows(): Paginator
    {
        return app(LocationModuleService::class)->handle('index', $this->search)
            ->orderBy(...array_values($this->sort))
            ->simplePaginate(perPage: $this->quantity)
            ->withQueryString();
    }
}
