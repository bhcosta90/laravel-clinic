<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Models\Permission\Can;
use App\Policies\Traits\CrudPolicyTrait;

final class RemedyPolicy
{
    use CrudPolicyTrait;

    protected function getViewPermission(): Can
    {
        return Can::RegistrationRemedyView;
    }

    protected function getEditPermission(): Can
    {
        return Can::RegistrationRemedyEdit;
    }
}
