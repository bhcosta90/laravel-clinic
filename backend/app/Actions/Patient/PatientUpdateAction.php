<?php

declare(strict_types=1);

namespace App\Actions\Patient;

use App\Models\Patient;

final readonly class PatientUpdateAction
{
    public function execute(Patient $model, string $name): Patient
    {
        return tap($model)->update(['name' => $name]);
    }
}
