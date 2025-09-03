<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Enums\Models\Permission\Can;
use App\Models\User;
use App\Policies\Traits\CrudPolicyTrait;

final class LocationModulePolicy
{
    use CrudPolicyTrait;

    public function export(User $user): bool
    {
        return $user->hasPermissionTo($this->getViewPermission());
    }

    public function import(User $user): bool
    {
        return $user->hasPermissionTo($this->getEditPermission());
    }

    public function location(User $user): bool
    {
        return $user->hasPermissionTo($this->getEditPermission());
    }

    protected function getViewPermission(): Can
    {
        return Can::StockLocationModuleView;
    }

    protected function getEditPermission(): Can
    {
        return Can::StockLocationModuleEdit;
    }
}
