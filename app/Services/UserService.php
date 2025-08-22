<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\User;
use App\Traits\Services\HandlesWithDependencies;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Auth;

final class UserService extends Service
{
    use HandlesWithDependencies;

    protected function model(): User
    {
        return new User();
    }

    protected function search(): array
    {
        return [
            'name',
            'email',
        ];
    }

    protected function filters(#[CurrentUser] $user): array
    {
        return [
            'id,!=' => $user->id,
        ];
    }

    protected function includes(): array
    {
        return ['role' => []];
    }

    protected function login(
        string $username,
        string $password,
        ?bool $remember = false
    ): bool {
        return Auth::attempt([
            'email'    => $username,
            'password' => $password,
        ], $remember);
    }
}
