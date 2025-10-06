<?php

declare(strict_types=1);

namespace App\Actions\Doctor;

use App\Models\Doctor;
use App\Models\User;
use SensitiveParameter;

final class DoctorCreateAction
{
    public function execute(string $name, string $crm, #[SensitiveParameter] ?string $password = null): Doctor
    {
        $user = User::create(['username' => $crm] + compact('password'));

        return $user->doctor()->create(compact('name', 'crm'));
    }
}
