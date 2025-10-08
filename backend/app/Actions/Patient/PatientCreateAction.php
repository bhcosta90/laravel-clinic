<?php

declare(strict_types=1);

namespace App\Actions\Patient;

use App\Models\Patient;

final readonly class PatientCreateAction
{
    public function execute(string $name): Patient
    {
        return Patient::query()->create(['name' => $name]);
    }
}
