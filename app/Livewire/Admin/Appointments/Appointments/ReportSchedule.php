<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Appointments\Appointments;

use App\Enums\Models\Appointment\Status;
use App\Models\Appointment;
use App\Report\GenerateReportByPdf;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

final class ReportSchedule extends Component
{
    public ?\App\Models\Report $report = null;

    public bool $modal                       = false;
    public string $date_start                = '';
    public string $date_end                  = '';
    public ?int $status                      = null;
    public ?int $is_payed                    = null;
    public string | int | null $agreement_id = null;
    public ?int $procedure_id                = null;
    public ?string $employee_id              = null;

    public function mount(): void
    {
        $this->date_start = now()->format('Y-m-d');
        $this->date_end   = now()->format('Y-m-d');
    }

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

        if (null !== $this->is_payed) {
            $filters['(byPayed)'] = $this->is_payed;
        }

        if ($this->status) {
            $filters['(status)'] = $this->status;
        }

        if ($this->agreement_id) {
            $filters['(byAgreement)'] = $this->agreement_id;
        }

        $this->report = $generateReportByPdf->execute(
            user: auth()->user(),
            name: 'Report schedule',
            view: 'pdf.report.schedule',
            model: Appointment::class,
            filters: $filters,
            orderColumn: 'date',
            orderDirection: 'desc'
        );

        $this->dispatch('report::index');
    }
}
