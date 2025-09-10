<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Insurances;

use App\Services\InsuranceService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

final class Index extends Component
{
    use WithPagination;

    public ?int $quantity = 5;

    public ?string $search = null;

    public array $sort = [
        'column'    => 'name',
        'direction' => 'desc',
    ];

    public function render(): View
    {
        return view('livewire.admin.insurances.index');
    }

    #[Computed]
    public function rows(): Paginator
    {
        return app(InsuranceService::class)->handle('index', $this->search)
            ->orderBy(...array_values($this->sort))
            ->simplePaginate($this->quantity)
            ->withQueryString();
    }

    #[Computed(persist: true)]
    public function headers(): array
    {
        return [
            ['index' => 'name', 'label' => 'Name'],
            ['index' => 'created_at', 'label' => 'Created'],
            ['index' => 'action', 'sortable' => false],
        ];
    }
}
