<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\Sku;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class SkuPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Sku $sku): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Sku $sku): bool
    {
    }

    public function delete(User $user, Sku $sku): bool
    {
    }

    public function restore(User $user, Sku $sku): bool
    {
    }

    public function forceDelete(User $user, Sku $sku): bool
    {
    }
}
