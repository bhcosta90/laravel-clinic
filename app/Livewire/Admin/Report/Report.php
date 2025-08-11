<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Report;

use App\Models\Report as ModelReport;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class Report extends Component
{
    use WithoutUrlPagination;
    use WithPagination;

    public ?string $name = null;

    public function mount(?string $name): void
    {
        $this->name = $name;
    }

    public function render(): View
    {
        return view('livewire.admin.report.report');
    }

    #[Computed(persist: true)]
    public function headers(): array
    {
        return [
            ['index' => 'name', 'label' => __('Name'), 'sortable' => false],
            ['index' => 'status', 'label' => __('Status'), 'sortable' => false],
            ['index' => 'created_at', 'label' => __('Created'), 'sortable' => false],
            ['index' => 'action', 'sortable' => false],
        ];
    }

    #[Computed]
    #[On('report::index')]
    public function rows()
    {
        return app(BuilderQuery::class)->execute(new ModelReport(), [], [
            '(user_id)' => auth()->id(),
            '(name)'    => $this->name,
        ])
            ->orderBy('id', 'desc')
            ->simplePaginate(perPage: 3);
    }
}
