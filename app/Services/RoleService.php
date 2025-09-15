<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\Role;
use App\Services\Traits\ByCode;
use Costa\Service\Service;

final class RoleService extends Service
{
    protected function model(): Role
    {
        return new Role();
    }

    protected function search(): array
    {
        return ['name'];
    }
}
