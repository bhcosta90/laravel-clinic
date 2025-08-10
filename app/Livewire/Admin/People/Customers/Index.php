<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\People\Customers;

use App\Models\Customer;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

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
            ['index' => 'birthday', 'label' => __('Birthday')],
            ['index' => 'document', 'label' => __('Document')],
            ['index' => 'created_at', 'label' => __('Created')],
            ['index' => 'action', 'sortable' => false],
        ];
    }

    public function render(): View
    {
        return view('livewire.admin.people.customers.index');
    }

    #[Computed]
    public function rows(): Paginator
    {
        return app(BuilderQuery::class)->execute(new Customer(), [], [
            '(byFilter,name;email)' => $this->search,
        ])
            ->orderBy(...array_values($this->sort))
            ->simplePaginate(perPage: $this->quantity)
            ->withQueryString();
    }
}
