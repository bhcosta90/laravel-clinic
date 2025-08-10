<?php

declare(strict_types=1);

namespace App\Policies\Traits;

use App\Enums\Models\Permission\Can;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

trait CrudPolicyTrait
{
    use HandlesAuthorization;

    abstract protected function getViewPermission(): Can;

    abstract protected function getEditPermission(): Can;

    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo($this->getViewPermission());
    }

    public function view(User $user): bool
    {
        return $user->hasPermissionTo($this->getViewPermission());
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo($this->getEditPermission());
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo($this->getEditPermission());
    }

    public function delete(User $user): bool
    {
        return $user->hasPermissionTo($this->getEditPermission());
    }
}
