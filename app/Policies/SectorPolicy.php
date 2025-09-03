<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\Sector;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class SectorPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Sector $sector): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Sector $sector): bool
    {
    }

    public function delete(User $user, Sector $sector): bool
    {
    }

    public function restore(User $user, Sector $sector): bool
    {
    }

    public function forceDelete(User $user, Sector $sector): bool
    {
    }
}
