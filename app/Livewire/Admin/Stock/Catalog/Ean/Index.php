<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Catalog\Ean;

use App\Models\Catalog;
use App\Services\EanService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

final class Index extends Component
{
    public ?Catalog $catalog = null;

    public bool $modal = false;

    #[Url]
    public array $sort = [
        'column'    => 'created_at',
        'direction' => 'asc',
    ];

    #[Computed(persist: true)]
    public function headers(): array
    {
        return [
            ['index' => 'ean', 'label' => __('Ean')],
            ['index' => 'created_at', 'label' => __('Created')],
            ['index' => 'action', 'sortable' => false],
        ];
    }

    #[On('load::catalog::ean')]
    public function load(Catalog $catalog): void
    {
        $this->catalog = $catalog;
        $this->modal   = true;
    }

    public function render(): View
    {
        return view('livewire.admin.stock.catalog.ean.index');
    }

    #[Computed]
    public function rows(): Collection
    {
        if ($this->catalog) {
            return collect([]);
        }

        return app(EanService::class)->handle('index')
            ->orderBy(...array_values($this->sort))
            ->get();
    }
}
