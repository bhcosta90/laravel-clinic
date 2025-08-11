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
        string $view,
        string $model,
        array $filters = [],
        ?string $orderColumn = null,
        ?string $orderDirection = null,
    ): Report {
        $report = Report::create([
            'user_id' => $user->id,
            'name'    => $name,
        ]);

        dispatch(new GenerateReportByPdfJob(
            $report->id,
            $name,
            $view,
            $model,
            $filters,
            $orderColumn,
            $orderDirection
        ));

        return $report;
    }
}
