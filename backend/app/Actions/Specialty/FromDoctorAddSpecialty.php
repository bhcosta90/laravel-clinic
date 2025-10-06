<?php

declare(strict_types=1);

namespace App\Actions\Specialty;

use App\Models\Specialty;

final class FromDoctorAddSpecialty
{
    /**
     * @param  array<int>  $doctors
     */
    public function execute(Specialty $specialty, array $doctors): void
    {
        if (empty($doctors)) {
            return;
        }
        $specialty->doctors()->attach($doctors);
    }
}
