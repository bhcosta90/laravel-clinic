<?php

declare(strict_types=1);

namespace App\Actions\Doctor\TimeOff;

use App\Models\DoctorTimeOff;

final readonly class DoctorTimeOffDeleteAction
{
    public function execute(
        int $idDoctor,
        int $idTimeOff,
    ): bool {
        return (bool) DoctorTimeOff::query()
            ->where('doctor_id', $idDoctor)
            ->where('id', $idTimeOff)
            ->delete();
    }
}
