<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Procedure;

final class ProcedureService extends Service
{
    protected function model(): Procedure
    {
        return new Procedure();
    }

    protected function search(): array
    {
        return ['name'];
    }
}
