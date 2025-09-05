<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Appointments\Appointments;

use App\Abstracts\Livewire\Report\AbstractPdfReport;
use App\Models\Appointment;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;

final class ReportProcedure extends AbstractPdfReport
{
    public ?int $procedure_id   = null;
    public ?string $employee_id = null;

    public function render(): View
    {
        return view('livewire.admin.appointments.appointments.report-procedure');
    }

    #[On('appointment::appointment::report-procedure')]
    public function load(): void
    {
        $this->slide = true;
    }

    protected function reportConfig(): array
    {
        return [
            'name'           => 'Report procedure',
            'view'           => 'pdf.report.procedure',
            'model'          => Appointment::class,
            'orderColumn'    => 'date',
            'orderDirection' => 'desc',
        ];
    }

    protected function customFilters(): array
    {
        $filters = [];

        if (null !== $this->procedure_id && 0 !== $this->procedure_id) {
            $filters['(procedure_id)'] = $this->procedure_id;
        }

        if (null !== $this->employee_id && '' !== $this->employee_id && '0' !== $this->employee_id) {
            $filters['(user_id)'] = $this->employee_id;
        }

        return $filters;
    }
}
