<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\RoomTimeOff;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class RoomTimeOffPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, RoomTimeOff $roomTimeOff): bool {}

    public function create(User $user): bool {}

    public function update(User $user, RoomTimeOff $roomTimeOff): bool {}

    public function delete(User $user, RoomTimeOff $roomTimeOff): bool {}

    public function restore(User $user, RoomTimeOff $roomTimeOff): bool {}

    public function forceDelete(User $user, RoomTimeOff $roomTimeOff): bool {}
}
