<?php

declare(strict_types=1);

namespace App\Actions\Doctor\FromSpecialty;

use App\Models\Doctor;

final class FromSpecialtyAddDoctor
{
    /**
     * @param  array<int>  $specialties
     */
    public function execute(Doctor $doctor, array $specialties): void
    {
        if (empty($specialties)) {
            return;
        }
        $doctor->specialties()->attach($specialties);
    }
}
