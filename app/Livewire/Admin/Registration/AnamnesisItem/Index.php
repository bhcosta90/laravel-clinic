<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\AnamnesisItem;

use App\Services\AnamnesisItemService;
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
    public ?int $quantity = 5;

    #[Url]
    public ?string $search = null;

    #[Url]
    public array $sort = [
        'column'    => 'name',
        'direction' => 'asc',
    ];

    #[Computed(persist: true)]
    public function headers(): array
    {
        return [
            ['index' => 'name', 'label' => __('Name')],
            ['index' => 'anamnesisGroup.name', 'label' => __('Anamnesis Group')],
            ['index' => 'created_at', 'label' => __('Created')],
            ['index' => 'action', 'sortable' => false],
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.registration.anamnesis-item.index');
    }

    #[Computed]
    public function rows(): Paginator
    {
        return app(AnamnesisItemService::class)->handle('index', $this->search)
            ->orderBy(...array_values($this->sort))
            ->simplePaginate(perPage: $this->quantity)
            ->withQueryString();
    }
}
