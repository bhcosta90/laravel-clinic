<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

final class DoctorTimeOffPolicy
{
    use HandlesAuthorization;

    public function viewAny(): true
    {
        return true;
    }

    public function view(): true
    {
        return true;
    }

    public function create(): true
    {
        return true;
    }

    public function update(): true
    {
        return true;
    }

    public function delete(): true
    {
        return true;
    }

    public function restore(): true
    {
        return true;
    }

    public function forceDelete(): true
    {
        return true;
    }
}
