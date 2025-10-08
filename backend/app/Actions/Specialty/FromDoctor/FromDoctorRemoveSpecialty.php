<?php

declare(strict_types=1);

namespace App\Actions\Specialty\FromDoctor;

use App\Models\Specialty;

final readonly class FromDoctorRemoveSpecialty
{
    /**
     * @param  array<int>  $doctorsIds
     */
    public function execute(Specialty $specialty, array $doctorsIds): void
    {
        if ($doctorsIds === []) {
            return;
        }

        $specialty->doctors()->detach($doctorsIds);
    }
}
