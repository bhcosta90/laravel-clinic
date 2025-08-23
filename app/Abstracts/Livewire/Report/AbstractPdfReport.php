<?php

declare(strict_types = 1);

namespace App\Abstracts\Livewire\Report;

use App\Models\Report;
use App\Report\GenerateReportByPdf;
use Livewire\Component;

/**
 * Base Livewire component for generating PDF reports with common date range and modal behavior.
 *
 * Children should:
 * - implement reportConfig(): array with keys [name, view, model, orderColumn, orderDirection]
 * - implement customFilters(): array returning additional filters to merge with date filters
 * - define their own render() view and event listener method(s) to open the modal.
 */
abstract class AbstractPdfReport extends Component
{
    public ?Report $report = null;

    public bool $modal         = false;
    public ?string $date_start = null;
    public ?string $date_end   = null;

    /**
     * Provide component-specific report configuration.
     * Expected keys: name, view, model, optional orderColumn, orderDirection.
     *
     * @return array{name:string,view:string,model:class-string,orderColumn?:string,orderDirection?:string}
     */
    abstract protected function reportConfig(): array;

    /**
     * Provide component-specific filters to be merged with the base date filters.
     */
    abstract protected function customFilters(): array;

    /**
     * Initialize default dates for the date range.
     */
    final public function mount(): void
    {
        $this->date_start = now()->format('Y-m-d');
        $this->date_end   = now()->format('Y-m-d');
    }

    /**
     * Handle saving the report using the common PDF generator.
     */
    final public function save(GenerateReportByPdf $generateReportByPdf): void
    {
        $filters = $this->baseDateFilters();
        $filters = array_merge($filters, $this->customFilters());

        $config = $this->reportConfig();

        $this->report = $generateReportByPdf->execute(
            user: auth()->user(),
            name: $config['name'],
            view: $config['view'],
            model: $config['model'],
            filters: $filters,
            orderColumn: $config['orderColumn'] ?? 'id',
            orderDirection: $config['orderDirection'] ?? 'desc'
        );

        $this->dispatch('report::index');
    }

    /**
     * Reset state when the modal visibility changes.
     */
    final public function updatedModal(): void
    {
        $this->resetExcept('modal');
        $this->date_start = now()->format('Y-m-d');
        $this->date_end   = now()->format('Y-m-d');
    }

    /**
     * Build date-based filters using the current component state.
     */
    protected function baseDateFilters(): array
    {
        $filters = [];

        if (null !== $this->date_start && '' !== $this->date_start && '0' !== $this->date_start) {
            $filters['(date,>=)'] = $this->date_start . ' 00:00:00';
        }

        if (null !== $this->date_end && '' !== $this->date_end && '0' !== $this->date_end) {
            $filters['(date,<=)'] = $this->date_end . ' 23:59:59';
        }

        return $filters;
    }
}
