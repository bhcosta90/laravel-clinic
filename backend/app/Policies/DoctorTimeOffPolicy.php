<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\DoctorTimeOff;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class DoctorTimeOffPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, DoctorTimeOff $doctorTimeOff): bool {}

    public function create(User $user): bool {}

    public function update(User $user, DoctorTimeOff $doctorTimeOff): bool {}

    public function delete(User $user, DoctorTimeOff $doctorTimeOff): bool {}

    public function restore(User $user, DoctorTimeOff $doctorTimeOff): bool {}

    public function forceDelete(User $user, DoctorTimeOff $doctorTimeOff): bool {}
}
