<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin\V1\Api;

use App\Models\Report;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use OwenIt\Auditing\Events\AuditCustom;

final class ReportController
{
    use AuthorizesRequests;

    public function viewFile(Report $report)
    {
        when(auth()->check() || !$report->can_shared, fn () => $this->authorize('show-file', $report));

        $content = Storage::drive($report->filesystem)->get($report->file);

        $name = sprintf('%s-%s.%s', str()->slug($report->name), now()->timestamp, 'pdf');

        if (!auth()->check() || auth()->id() !== $report->user_id) {
            $report->auditEvent    = 'open-file';
            $report->isCustomEvent = true;
            Event::dispatch(new AuditCustom($report));
        }

        return response($content, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $name . '"');
    }
}
