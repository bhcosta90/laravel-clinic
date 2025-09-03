<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\LocationModule;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class LocationModulePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, LocationModule $locationModule): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, LocationModule $locationModule): bool
    {
    }

    public function delete(User $user, LocationModule $locationModule): bool
    {
    }

    public function restore(User $user, LocationModule $locationModule): bool
    {
    }

    public function forceDelete(User $user, LocationModule $locationModule): bool
    {
    }
}
