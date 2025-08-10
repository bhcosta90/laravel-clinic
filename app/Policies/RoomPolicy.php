<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Models\Permission\Can;
use App\Policies\Traits\CrudPolicyTrait;

final class RoomPolicy
{
    use CrudPolicyTrait;

    protected function getViewPermission(): Can
    {
        return Can::RegistrationRoomView;
    }

    protected function getEditPermission(): Can
    {
        return Can::RegistrationRoomEdit;
    }
}
