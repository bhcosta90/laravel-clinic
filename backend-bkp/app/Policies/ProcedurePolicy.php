<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\Procedure;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class ProcedurePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
    }

    public function view(User $user, Procedure $procedure): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Procedure $procedure): bool
    {
    }

    public function delete(User $user, Procedure $procedure): bool
    {
    }

    public function restore(User $user, Procedure $procedure): bool
    {
    }

    public function forceDelete(User $user, Procedure $procedure): bool
    {
    }
}
