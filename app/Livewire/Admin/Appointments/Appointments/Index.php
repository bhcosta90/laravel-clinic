<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Appointments\Appointments;

use App\Models\Appointment;
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
    public ?string $date = null;

    #[Url]
    public ?string $user_id = null;

    #[Url]
    public ?string $search = null;

    #[Url]
    public array $sort = [
        'column'    => 'date',
        'direction' => 'asc',
    ];

    public function mount(): void
    {
        if (blank($this->date)) {
            $this->date = now()->format('Y-m-d');
        }
    }

    public function render(): View
    {
        return view('livewire.admin.appointments.appointments.index');
    }

    public function updatedDate(): void
    {
        $this->setPage(1);
    }

    public function updatedUserId(): void
    {
        $this->setPage(1);
    }

    #[Computed(persist: true)]
    public function headers(): array
    {
        return [
            ['index' => 'hour', 'label' => __('Hour')],
            ['index' => 'customer.name', 'label' => __('Customer'), 'sortable' => false],
            ['index' => 'procedure.name', 'label' => __('Procedure'), 'sortable' => false],
            ['index' => 'is_return', 'label' => __('There return'), 'sortable' => false],
            ['index' => 'created_at', 'label' => __('Created')],
            ['index' => 'action', 'sortable' => false],
        ];
    }

    #[Computed]
    public function rows(): Paginator
    {
        return app(BuilderQuery::class)->execute(new Appointment(), [
            'customer'  => ['id', 'name'],
            'procedure' => ['id', 'name'],
            'user'      => ['id', 'name'],
        ], [
            '(byFilter,name;email)' => $this->search,
            '(byDate)'              => $this->date,
            '(user_id,=)'           => $this->user_id,
        ])
            ->orderBy('is_paid', 'desc')
            ->orderBy(...array_values($this->sort))
            ->simplePaginate(perPage: $this->quantity)
            ->withQueryString();
    }
}
