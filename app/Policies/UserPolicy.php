<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Enums\Models\Permission\Can;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(Can::PeopleUserView);
    }

    public function view(User $user): bool
    {
        return $user->hasPermissionTo(Can::PeopleUserView);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo(Can::PeopleUserEdit);
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo(Can::PeopleUserEdit);
    }

    public function delete(User $user, User $userActual): bool
    {
        return !$userActual->is($user) && $user->hasPermissionTo(Can::PeopleUserEdit);
    }

    public function impersonate(User $user, User $userActual): bool
    {
        return !auth()->user()->is($userActual) && $user->hasPermissionTo(Can::PeopleUserImpersonate);
    }

    public function permissions(User $user): bool
    {
        return $user->hasPermissionTo(Can::PeopleUserEdit);
    }

    public function viewEmployeeAny(User $user): bool
    {
        return $user->hasPermissionTo(Can::PeopleUserView);
    }

    public function viewEmployee(User $user): bool
    {
        return $user->hasPermissionTo(Can::PeopleUserView);
    }

    public function createEmployee(User $user): bool
    {
        return $user->hasPermissionTo(Can::PeopleUserEdit);
    }

    public function updateEmployee(User $user): bool
    {
        return $user->hasPermissionTo(Can::PeopleUserEdit);
    }

    public function deleteEmployee(User $user, User $userActual): bool
    {
        return !$userActual->is($user) && $user->hasPermissionTo(Can::PeopleUserEdit);
    }
}
