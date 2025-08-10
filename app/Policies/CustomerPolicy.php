<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Enums\Models\Permission\Can;
use App\Models\User;
use App\Policies\Traits\CrudPolicyTrait;

final class CustomerPolicy
{
    use CrudPolicyTrait;

    public function birthday(User $user): bool
    {
        return $user->hasPermissionTo(Can::PeopleUserView);
    }

    protected function getViewPermission(): Can
    {
        return Can::PeopleUserView;
    }

    protected function getEditPermission(): Can
    {
        return Can::PeopleUserEdit;
    }
}
