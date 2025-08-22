<?php

declare(strict_types = 1);

namespace App\Services;

use App\Http\Requests\User\StoreRequest;
use App\Models\User;
use App\Traits\Services\HandlesWithDependencies;
use App\Traits\Services\ValidateService;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\Auth;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class UserService
{
    use HandlesWithDependencies;
    use ValidateService;

    public function store(array $data): User
    {
        $data = $this->validate(StoreRequest::class, $data);

        return User::create($data);
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
        bool $remember = false
    ): bool {
        return Auth::attempt([
            'email'    => $username,
            'password' => $password,
        ], $remember);
    }
}
