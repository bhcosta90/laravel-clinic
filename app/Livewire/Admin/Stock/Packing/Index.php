<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Packing;

use App\Services\PackingService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

final class Index extends Component
{
    use WithPagination;

    public Model $model;

    #[Url]
    public ?int $quantity = 15;

    #[Url]
    public array $sort = [
        'column'    => 'id',
        'direction' => 'asc',
    ];

    #[Computed(persist: true)]
    public function headers(): array
    {
        return [
            ['index' => 'level', 'label' => __('Level'), 'sortable' => false],
            ['index' => 'quantity', 'label' => __('Quantity'), 'sortable' => false],
            ['index' => 'weight', 'label' => __('Weight'), 'sortable' => false],
            ['index' => 'length', 'label' => __('Length'), 'sortable' => false],
            ['index' => 'width', 'label' => __('Width'), 'sortable' => false],
            ['index' => 'height', 'label' => __('Height'), 'sortable' => false],
            ['index' => 'action', 'sortable' => false],
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.stock.packing.index');
    }

    #[Computed]
    public function rows(): Paginator
    {
        return app(PackingService::class)->handle('index', null, [
            '(model_type)' => $this->model::class,
            '(model_id)'   => $this->model->id,
        ])
            ->orderBy(...array_values($this->sort))
            ->simplePaginate(perPage: $this->quantity)
            ->withQueryString();
    }
}
