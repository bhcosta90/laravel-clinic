<?php

declare(strict_types=1);

namespace App\Actions\Doctor;

use App\Models\Doctor;

final class FromSpecialtyRemoveDoctor
{
    /**
     * @param  array<int>  $specialties
     */
    public function execute(Doctor $doctor, array $specialties): void
    {
        if (empty($specialties)) {
            return;
        }
        $doctor->specialties()->detach($specialties);
    }
}
