<?php

namespace App\Policies;

use App\Models\Catalog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CatalogPolicy{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        //
    }

    public function view(User $user, Catalog $catalog): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Catalog $catalog): bool
    {
    }

    public function delete(User $user, Catalog $catalog): bool
    {
    }

    public function restore(User $user, Catalog $catalog): bool
    {
    }

    public function forceDelete(User $user, Catalog $catalog): bool
    {
    }
}
