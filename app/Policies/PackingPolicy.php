<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\Packing;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class PackingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Packing $packing): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Packing $packing): bool
    {
    }

    public function delete(User $user, Packing $packing): bool
    {
    }

    public function restore(User $user, Packing $packing): bool
    {
    }

    public function forceDelete(User $user, Packing $packing): bool
    {
    }
}
