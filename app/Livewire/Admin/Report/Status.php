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
    public function getUserIdProperty(): int
    {
        return (int) auth()->id();
    }

    // Listen to the authenticated user's private channel for this event
    #[On('echo-private:App.Models.User.{userId},ReportFinishEvent')]
    public function handleJobFinished($payload): void
    {
        Log::info($payload);

        if ($this->report) {
            $this->report->refresh();
        }
    }
}
