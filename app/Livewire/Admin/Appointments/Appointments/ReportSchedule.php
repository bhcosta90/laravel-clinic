<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Appointments\Appointments;

use App\Abstracts\Livewire\Report\AbstractPdfReport;
use App\Enums\Models\Appointment\Status;
use App\Models\Appointment;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

final class ReportSchedule extends AbstractPdfReport
{
    public ?int $status                      = null;
    public ?int $is_payed                    = null;
    public string | int | null $agreement_id = null;
    public ?int $procedure_id                = null;
    public ?string $employee_id              = null;

    public function render(): View
    {
        return view('livewire.admin.appointments.appointments.report-schedule');
    }

    #[On('appointment::appointment::report-schedule')]
    public function load(): void
    {
        $this->modal = true;
    }

    #[Computed(persist: true)]
    public function status(): array
    {
        return array_map(fn (Status $item): array => [
            'name'  => __($item->label()),
            'value' => $item->value,
        ], Status::cases());
    }

    #[Computed(persist: true)]
    public function payed(): array
    {
        return [
            ['name' => __('Yes'), 'value' => 1],
            ['name' => __('No'), 'value' => 0],
        ];
    }

    protected function reportConfig(): array
    {
        return [
            'name'           => 'Report schedule',
            'view'           => 'pdf.report.schedule',
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

        if (null !== $this->is_payed) {
            $filters['(byPayed)'] = $this->is_payed;
        }

        if (null !== $this->status && 0 !== $this->status) {
            $filters['(status)'] = $this->status;
        }

        if ('' !== $this->agreement_id && '0' !== $this->agreement_id && 0 !== $this->agreement_id) {
            $filters['(byAgreement)'] = $this->agreement_id;
        }

        return $filters;
    }
}
