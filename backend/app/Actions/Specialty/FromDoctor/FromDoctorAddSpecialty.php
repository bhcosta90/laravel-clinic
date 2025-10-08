<?php

declare(strict_types=1);

namespace App\Actions\Specialty\FromDoctor;

use App\Models\Specialty;

final readonly class FromDoctorAddSpecialty
{
    /**
     * @param  array<int>  $doctors
     */
    public function execute(Specialty $specialty, array $doctors): void
    {
        if ($doctors === []) {
            return;
        }
        $specialty->doctors()->attach($doctors);
    }
}
