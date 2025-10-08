<?php

declare(strict_types=1);

namespace App\Actions\Patient;

use App\Models\Patient;

final readonly class PatientDeleteAction
{
    public function execute(Patient $model): bool
    {
        return $model->delete();
    }
}
