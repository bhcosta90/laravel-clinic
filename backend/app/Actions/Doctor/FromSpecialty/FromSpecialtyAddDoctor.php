<?php

declare(strict_types=1);

namespace App\Actions\Doctor\FromSpecialty;

use App\Models\Doctor;

final readonly class FromSpecialtyAddDoctor
{
    public function execute(Doctor $doctor, array $specialties): void
    {
        if ($specialties === []) {
            return;
        }
        $doctor->specialties()->attach($specialties);
    }
}
