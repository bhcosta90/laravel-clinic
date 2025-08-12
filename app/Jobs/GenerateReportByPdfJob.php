<?php

declare(strict_types = 1);

namespace App\Jobs;

use App\Enums\Models\Report\Status;
use App\Enums\Queue\Queue;
use App\Events\ReportFinishEvent;
use App\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;
use Throwable;

final class GenerateReportByPdfJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public int $reportId,
        public string $name,
        public string $view,
        public string $model,
        public array $filters,
        public ?string $orderColumn,
        public ?string $orderDirection,
    ) {
        $this->onQueue(Queue::Report);
    }

    public function handle(): void
    {
        $report = Report::find($this->reportId);

        $report->status = Status::Processing;
        $report->save();

        $event = new ReportFinishEvent($report->user_id, $this->reportId);

        broadcast($event);

        try {
            $report->status = Status::Completed;
            $report->file   = $this->generatePdf();
            $report->type   = 'pdf';
            $report->save();

            broadcast($event);
        } catch (Throwable $e) {
            $report->status = Status::Error;
            $report->save();

            broadcast($event);

            throw $e;
        }

    }

    private function generatePdf(): string
    {
        $model = $this->model;

        $query = app(BuilderQuery::class)
            ->execute(new $model(), [], $this->filters);

        if ($this->orderColumn !== null && $this->orderColumn !== '' && $this->orderColumn !== '0') {
            $query->orderBy($this->orderColumn, $this->orderDirection);
        }

        $result = $query->get();

        $content = Pdf::loadView($this->view, ['result' => $result])
            ->stream();

        $name = sha1($this->name);
        $id   = sha1((string) $this->reportId);

        Storage::put($nameFile = "report/{$name}/{$id}.pdf", $content->getContent());

        return $nameFile;
    }
}
