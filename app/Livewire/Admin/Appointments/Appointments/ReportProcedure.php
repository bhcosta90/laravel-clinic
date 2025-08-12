<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Appointments\Appointments;

use App\Models\Appointment;
use App\Report\GenerateReportByPdf;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class ReportProcedure extends Component
{
    public ?\App\Models\Report $report = null;

    public bool $modal          = false;
    public ?string $date_start  = null;
    public ?string $date_end    = null;
    public ?int $procedure_id   = null;
    public ?string $employee_id = null;

    public function mount(): void
    {
        $this->date_start = now()->format('Y-m-d');
        $this->date_end   = now()->format('Y-m-d');
    }

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

        if ($this->date_start) {
            $filters['(date,>=)'] = $this->date_start . ' 00:00:00';
        }

        if ($this->date_end) {
            $filters['(date,<=)'] = $this->date_end . ' 23:59:59';
        }

        if ($this->procedure_id) {
            $filters['(procedure_id)'] = $this->procedure_id;
        }

        if ($this->employee_id) {
            $filters['(user_id)'] = $this->employee_id;
        }

        $this->report = $generateReportByPdf->execute(
            user: auth()->user(),
            name: 'Report procedure',
            view: 'pdf.report.procedure',
            model: Appointment::class,
            filters: $filters,
            orderColumn: 'date',
            orderDirection: 'desc'
        );

        $this->dispatch('report::index');
    }

    public function updatedModal(): void
    {
        $this->resetExcept('modal');
        $this->date_start = now()->format('Y-m-d');
        $this->date_end   = now()->format('Y-m-d');
    }
}
