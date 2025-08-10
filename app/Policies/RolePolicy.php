<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Models\Permission\Can;
use App\Models\User;
use App\Policies\Traits\CrudPolicyTrait;

final class RolePolicy
{
    use CrudPolicyTrait;

    public function permissions(User $user): bool
    {
        return $user->hasPermissionTo(Can::RegistrationRoleEdit);
    }

    protected function getViewPermission(): Can
    {
        return Can::RegistrationRoleView;
    }

    protected function getEditPermission(): Can
    {
        return Can::RegistrationRoleEdit;
    }
}
