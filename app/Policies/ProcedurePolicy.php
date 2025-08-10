<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Enums\Models\Permission\Can;
use App\Models\User;
use App\Policies\Traits\CrudPolicyTrait;

final class ProcedurePolicy
{
    use CrudPolicyTrait;

    public function generateReport(User $user): bool
    {
        return $user->hasPermissionTo(Can::RegistrationProcedureReport);
    }

    protected function getViewPermission(): Can
    {
        return Can::RegistrationProcedureView;
    }

    protected function getEditPermission(): Can
    {
        return Can::RegistrationProcedureEdit;
    }
}
