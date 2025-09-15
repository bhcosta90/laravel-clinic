<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\User;
use Costa\Service\Service;

final class UserService extends Service
{
    public function showByCode($code): User
    {
        return User::findOrFail(User::decodeHashCode($code));
    }

    protected function model(): User
    {
        return new User();
    }

    protected function search(): array
    {
        return ['code', 'name'];
    }
}
