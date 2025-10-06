<?php

declare(strict_types=1);

namespace App\Actions\Specialty;

use App\Models\Specialty;

final class FromDoctorSyncSpecialty
{
    /**
     * @param  array<int>  $doctorsIds
     */
    public function execute(Specialty $specialty, array $doctorsIds): void
    {
        $specialty->doctors()->sync($doctorsIds);
    }
}
