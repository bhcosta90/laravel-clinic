<?php

declare(strict_types = 1);

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

final class GenerateReportByPdfJob implements ShouldQueue
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

        // Notify the specific user via private channel
        broadcast(new ReportFinishEvent($this->reportId, (string) $report->user_id));

        sleep(10);

        $report->status = Status::Completed;
        $report->file   = 'path/to/generated/report.pdf';
        $report->type   = 'pdf';
        $report->save();

        // Notify the specific user via private channel
        broadcast(new ReportFinishEvent($this->reportId, (string) $report->user_id));

    }
}
