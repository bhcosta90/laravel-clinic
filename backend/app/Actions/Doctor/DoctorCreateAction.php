<?php

declare(strict_types=1);

namespace App\Actions\Doctor;

use App\Models\Doctor;
use App\Models\User;
use SensitiveParameter;

final readonly class DoctorCreateAction
{
    public function execute(string $name, string $crm, #[SensitiveParameter] string $password): Doctor
    {
        $user = User::query()->create(['username' => $crm] + ['password' => $password]);

        /** @var Doctor */
        return $user->doctor()->create(['name' => $name, 'crm' => $crm]);
    }
}
