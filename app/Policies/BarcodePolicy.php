<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\Barcode;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class BarcodePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Barcode $barcode): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Barcode $barcode): bool
    {
    }

    public function delete(User $user, Barcode $barcode): bool
    {
    }

    public function restore(User $user, Barcode $barcode): bool
    {
    }

    public function forceDelete(User $user, Barcode $barcode): bool
    {
    }
}
