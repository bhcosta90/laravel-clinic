<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\Patient;
use Costa\Service\Service;

final class PatientService extends Service
{
    protected function model(): Patient
    {
        return new Patient();
    }

    protected function search(): array
    {
        return ['code', 'name'];
    }
}
