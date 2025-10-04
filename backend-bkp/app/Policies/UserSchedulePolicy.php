<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\User;
use App\Models\UserSchedule;
use Illuminate\Auth\Access\HandlesAuthorization;

final class UserSchedulePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
    }

    public function view(User $user, UserSchedule $userSchedule): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, UserSchedule $userSchedule): bool
    {
    }

    public function delete(User $user, UserSchedule $userSchedule): bool
    {
    }

    public function restore(User $user, UserSchedule $userSchedule): bool
    {
    }

    public function forceDelete(User $user, UserSchedule $userSchedule): bool
    {
    }
}
