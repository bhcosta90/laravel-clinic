<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Report;

final class ReportService extends Service
{
    protected function model(): Report
    {
        return new Report();
    }

    protected function search(): array
    {
        return ['name'];
    }
}
