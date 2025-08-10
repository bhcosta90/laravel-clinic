<?php

declare(strict_types = 1);

namespace App\Report;

use App\Jobs\GenerateReportByPdfJob;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

final class GenerateReportByPdf
{
    public function execute(
        User $user,
        string $name,
        Model $model,
    ): Report {
        $modelClass  = $model::class;
        $modelObject = new $modelClass();

        $report = Report::create([
            'user_id' => $user->id,
            'name'    => $name,
            'key'     => $id = str()->uuid(),
            'model'   => $modelObject->getMorphClass(),
        ]);

        dispatch(new GenerateReportByPdfJob($report->id));

        return $report;
    }
}
