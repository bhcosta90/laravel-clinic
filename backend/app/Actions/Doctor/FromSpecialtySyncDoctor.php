<?php

declare(strict_types=1);

namespace App\Actions\Doctor;

use App\Models\Doctor;

final class FromSpecialtySyncDoctor
{
    /**
     * @param  array<int>  $specialties
     */
    public function execute(Doctor $doctor, array $specialties): void
    {
        $doctor->specialties()->sync($specialties);
    }
}
