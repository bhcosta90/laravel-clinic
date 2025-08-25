<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\Triage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class TriagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Triage $triage): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Triage $triage): bool
    {
    }

    public function delete(User $user, Triage $triage): bool
    {
    }

    public function restore(User $user, Triage $triage): bool
    {
    }

    public function forceDelete(User $user, Triage $triage): bool
    {
    }
}
