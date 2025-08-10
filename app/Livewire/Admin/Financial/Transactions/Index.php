<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Financial\Transactions;

use App\Enums\Models\Transaction\Type;
use App\Models\Transaction;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class Index extends Component
{
    use WithPagination;

    public Type $type;

    #[Url]
    public ?int $quantity = 5;

    #[Url]
    public ?string $search = null;

    #[Url]
    public array $sort = [
        'column'    => 'name',
        'direction' => 'asc',
    ];

    public function mount(): void
    {
        $this->authorize('view' . mb_ucfirst($this->type->value) . 'Any', Transaction::class);
    }

    #[Computed(persist: true)]
    public function headers(): array
    {
        $columns = match ($this->type) {
            Type::Incomes => [
                ['index' => 'customer.name', 'label' => __('Customer')],
                ['index' => 'agreement.name', 'label' => __('Agreement')],
            ],
            Type::Expenses => [
                ['index' => 'user.name', 'label' => __('Employee')],
            ],
        };

        return array_merge([
            ['index' => 'name', 'label' => __('Name')],
        ], $columns, [
            ['index' => 'created_at', 'label' => __('Created')],
            ['index' => 'action', 'sortable' => false],
        ]);
    }

    #[On('load::transactions')]
    public function render(): View
    {
        return view('livewire.admin.financial.transactions.index');
    }

    #[Computed]
    public function rows(): Paginator
    {
        $fields = match ($this->type) {
            Type::Incomes => [
                'customer'  => ['id', 'name'],
                'agreement' => ['id', 'name'],
            ],
            Type::Expenses => [
                'user' => ['id', 'name'],
            ],
            Type::Transfers => throw new Exception('To be implemented'),
        };

        return app(BuilderQuery::class)->execute(new Transaction(), $fields, [
            '(byFilter,name;email)' => $this->search,
        ])
            ->where('type', '=', $this->type)
            ->orderBy(...array_values($this->sort))
            ->simplePaginate(perPage: $this->quantity)
            ->withQueryString();
    }
}
