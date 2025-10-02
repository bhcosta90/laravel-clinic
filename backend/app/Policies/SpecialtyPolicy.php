<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\Specialty;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class SpecialtyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
    }

    public function view(User $user, Specialty $specialty): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Specialty $specialty): bool
    {
    }

    public function delete(User $user, Specialty $specialty): bool
    {
    }

    public function restore(User $user, Specialty $specialty): bool
    {
    }

    public function forceDelete(User $user, Specialty $specialty): bool
    {
    }
}
