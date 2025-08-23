<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Role;

final class RoleService extends Service
{
    protected function model(): Role
    {
        return new Role();
    }

    protected function search(): array
    {
        return ['full_name'];
    }
}
