<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Report;

use App\Models\Report;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Status extends Component
{
    public ?Report $report = null;

    public function render(): View
    {
        return view('livewire.admin.report.status');
    }

    // Provide dynamic placeholder for private Echo channel
    public function getUserIdProperty(): string
    {
        return (string) auth()->id();
    }

    // Provide dynamic placeholder for private Echo channel
    public function getReportIdProperty(): string
    {
        return (string) $this->report?->id;
    }

    // Listen to the authenticated user's private channel for this event
    #[On('echo-private:App.Models.Report.{userId}.{reportId},ReportFinishEvent')]
    public function handleJobFinished($payload): void
    {
        if ($this->report) {
            $this->report->refresh();
        }
    }
}
