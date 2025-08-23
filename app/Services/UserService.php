<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\User;

final class UserService extends Service
{
    protected function model(): User
    {
        return new User();
    }

    protected function search(): array
    {
        return ['name'];
    }

    protected function includes(): array
    {
        return ['role' => []];
    }
}
