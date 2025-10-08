<?php

declare(strict_types=1);

namespace App\Actions\Doctor;

use App\Models\Doctor;

final readonly class DoctorUpdateAction
{
    public function execute(Doctor $model, string $name, string $crm): Doctor
    {
        return tap($model)->update(['name' => $name, 'crm' => $crm]);
    }
}
