<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\User;
use App\Services\Traits\ByCode;
use Costa\Service\Service;

final class UserService extends Service
{
    protected function model(): User
    {
        return new User();
    }

    protected function search(): array
    {
        return ['code', 'name'];
    }
}
