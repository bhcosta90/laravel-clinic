<?php

declare(strict_types=1);

namespace App\Actions\Specialty;

use App\Models\Specialty;

final class FromDoctorRemoveSpecialty
{
    /**
     * @param  array<int>  $doctorsIds
     */
    public function execute(Specialty $specialty, array $doctorsIds): void
    {
        if (empty($doctorsIds)) {
            return;
        }

        $specialty->doctors()->detach($doctorsIds);
    }
}
