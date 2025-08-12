<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Report;

use App\Models\Report;
use Illuminate\View\View;
use Livewire\Component;

final class Status extends Component
{
    public ?Report $report = null;

    public bool $min = false;

    public function render(): View
    {
        return view('livewire.admin.report.status');
    }

    // Provide dynamic placeholder for private Echo channel
    public function getUserIdProperty(): int
    {
        return (int) auth()->id();
    }

    // Provide dynamic placeholder for private Echo channel
    public function getReportIdProperty(): string
    {
        return (string) $this->report?->id;
    }

    public function getListeners(): array
    {
        if (blank($this->report)) {
            return [];
        }

        return [
            'echo-private:App.Models.ReportSchedule.{userId}.{reportId},ReportFinishEvent' => 'handleJobFinished',
        ];
    }

    public function handleJobFinished(): void
    {
        if ($this->report instanceof Report) {
            $this->report->refresh();
        }
    }
}
