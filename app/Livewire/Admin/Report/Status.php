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

    #[On('echo:report,ReportFinishEvent')]
    public function handleJobFinished($payload): void
    {
        Log::info($payload);

        if ($this->report) {
            $this->report->refresh();
        }
    }
}
