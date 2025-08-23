<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Permission;

final class PermissionService extends Service
{
    protected function model(): Permission
    {
        return new Permission();
    }

    protected function search(): array
    {
        return ['full_name'];
    }
}
