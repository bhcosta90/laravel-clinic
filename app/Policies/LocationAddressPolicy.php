<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\LocationAddress;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class LocationAddressPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, LocationAddress $localAddress): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, LocationAddress $localAddress): bool
    {
    }

    public function delete(User $user, LocationAddress $localAddress): bool
    {
    }

    public function restore(User $user, LocationAddress $localAddress): bool
    {
    }

    public function forceDelete(User $user, LocationAddress $localAddress): bool
    {
    }
}
