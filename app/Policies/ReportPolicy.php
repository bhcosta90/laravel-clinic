<?php

declare(strict_types = 1);

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class ReportPolicy
{
    use HandlesAuthorization;

    public function showFile(User $user, Report $report): bool
    {
        return $user->id === $report->user_id;
    }
}
