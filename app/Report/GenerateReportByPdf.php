<?php

declare(strict_types = 1);

namespace App\Report;

use App\Jobs\GenerateReportByPdfJob;
use App\Models\Report;
use App\Models\User;

final class GenerateReportByPdf
{
    public function execute(
        User $user,
        string $name,
    ): Report {
        $report = Report::create([
            'user_id' => $user->id,
            'name'    => $name,
            'key'     => str()->uuid(),
        ]);

        dispatch(new GenerateReportByPdfJob($report->id));

        return $report;
    }
}
