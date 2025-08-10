<?php

namespace App\Jobs;

use App\Enums\Models\Report\Status;
use App\Enums\Queue\Queue;
use App\Events\ReportFinishEvent;
use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateReportByPdfJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public int $reportId)
    {
        $this->onQueue(Queue::Low);
    }

    public function handle(): void
    {
        $report = Report::find($this->reportId);

        $report->status = Status::Processing;
        $report->save();

        broadcast(new ReportFinishEvent($this->reportId));

        sleep(5);

        $report->status = Status::Completed;
        $report->save();

        broadcast(new ReportFinishEvent($this->reportId));

    }
}
