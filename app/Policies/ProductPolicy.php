<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\Catalog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Catalog $product): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Catalog $product): bool
    {
    }

    public function delete(User $user, Catalog $product): bool
    {
    }

    public function restore(User $user, Catalog $product): bool
    {
    }

    public function forceDelete(User $user, Catalog $product): bool
    {
    }
}
