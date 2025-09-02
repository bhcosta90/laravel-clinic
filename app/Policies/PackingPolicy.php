<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\Packing;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class PackingPolicy
{
    use HandlesAuthorization;
}
