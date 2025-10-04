<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class PatientPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
    }

    public function view(User $user, Patient $patient): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Patient $patient): bool
    {
    }

    public function delete(User $user, Patient $patient): bool
    {
    }

    public function restore(User $user, Patient $patient): bool
    {
    }

    public function forceDelete(User $user, Patient $patient): bool
    {
    }
}
