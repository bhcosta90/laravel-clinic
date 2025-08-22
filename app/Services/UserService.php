<?php

declare(strict_types = 1);

namespace App\Services;

use App\Models\User;
use App\Traits\Services\HandlesWithDependencies;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Auth;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;
use QuantumTecnology\ControllerBasicsExtension\Services\RelationshipService;

final class UserService
{
    use HandlesWithDependencies;

    protected function store(array $data): User
    {
        return app(RelationshipService::class)->execute(new User(), $data);
    }

    protected function update(User $user, array $data): User
    {
        return app(RelationshipService::class)->execute($user, $data);
    }

    protected function delete(User $user): bool
    {
        return $user->delete();
    }

    protected function index(#[CurrentUser] $user, ?string $search)
    {
        return app(BuilderQuery::class)->execute(new User(), [
            'role' => ['name'],
        ], [
            '(byFilter,name;email)' => $search,
        ])->where('id', '!=', $user->id);
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
