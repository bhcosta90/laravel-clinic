<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Insurance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class InsurancePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, Insurance $insurance): bool {}

    public function create(User $user): bool {}

    public function update(User $user, Insurance $insurance): bool {}

    public function delete(User $user, Insurance $insurance): bool {}

    public function restore(User $user, Insurance $insurance): bool {}

    public function forceDelete(User $user, Insurance $insurance): bool {}
}
