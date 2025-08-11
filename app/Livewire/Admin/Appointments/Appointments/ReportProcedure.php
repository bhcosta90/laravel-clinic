<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Appointments\Appointments;

use App\Models\Agreement;
use App\Report\GenerateReportByPdf;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class ReportProcedure extends Component
{
    public ?\App\Models\Report $report = null;

    public bool $modal        = false;
    public string $date_start = '';
    public string $date_end   = '';
    public ?int $procedure_id = null;
    public ?int $employee_id  = null;

    public function render(): View
    {
        return view('livewire.admin.appointments.appointments.report-procedure');
    }

    #[On('appointment::appointment::report-procedure')]
    public function load(): void
    {
        $this->modal = true;
    }

    public function save(GenerateReportByPdf $generateReportByPdf): void
    {
        $filters = [];

        $this->report = $generateReportByPdf->execute(
            user: auth()->user(),
            name: 'report.procedure',
            view: 'pdf.report.procedure',
            model: Agreement::class,
            filters: $filters,
        );

        $this->dispatch('saved');
    }
}
