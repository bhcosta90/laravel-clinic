<?php

declare(strict_types=1);

namespace App\Actions\Doctor;

use App\Models\Doctor;

final readonly class DoctorDeleteAction
{
    public function execute(Doctor $doctor): bool
    {
        $user = $doctor->user;

        return $doctor->delete() && $user->delete();
    }
}
