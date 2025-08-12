<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Api;

use App\Models\Report;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

final class ReportController
{
    use AuthorizesRequests;

    public function viewFile(Report $report)
    {
        $this->authorize('show-file', $report);

        $content = Storage::drive($report->filesystem)->get($report->file);

        $name = sprintf('%s-%s.%s', str()->slug($report->name), now()->timestamp, 'pdf');

        return response($content, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $name . '"');
    }
}
