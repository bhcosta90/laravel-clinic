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
use Spatie\LaravelPdf\Facades\Pdf;

final class GenerateReportByPdfJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(public int $reportId, public string $model, public array $filters = [])
    {
        $this->onQueue(Queue::Low);
    }

    public function handle(): void
    {
        $report = Report::find($this->reportId);

        $report->status = Status::Processing;
        $report->save();

        broadcast(new ReportFinishEvent($this->reportId, (string) $report->user_id));

        $nameFile = $this->generatePdf($this->model, $this->filters, sha1((string) $this->reportId));

        $report->status = Status::Completed;
        $report->file   = $nameFile;
        $report->type   = 'pdf';
        $report->save();

        broadcast(new ReportFinishEvent($this->reportId, (string) $report->user_id));

    }

    protected function generatePdf(string $model, array $filters, string $id): string
    {
        Pdf::view('pdf.report.default')
            ->save($nameFile = "report/{$id}.pdf");

        return $nameFile;
    }
}
