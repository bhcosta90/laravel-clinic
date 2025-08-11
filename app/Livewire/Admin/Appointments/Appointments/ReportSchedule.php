<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Appointments\Appointments;

use App\Enums\Models\Appointment\Status;
use App\Models\Agreement;
use App\Report\GenerateReportByPdf;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

final class ReportSchedule extends Component
{
    public ?\App\Models\Report $report = null;

    public bool $modal        = false;
    public string $date_start = '';
    public string $date_end   = '';
    public ?int $status       = null;
    public ?int $is_payed     = null;
    public ?int $agreement_id = null;
    public ?int $procedure_id = null;
    public ?int $employee_id  = null;

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

        $this->report = $generateReportByPdf->execute(
            user: auth()->user(),
            name: 'report.schedule',
            model: Agreement::class,
            filters: $filters,
        );
    }
}
