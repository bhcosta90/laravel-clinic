<?php

declare(strict_types = 1);

use App\Models\Report;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', fn ($user, $id): bool => (int) $user->id === (int) $id);

Broadcast::channel('App.Models.ReportSchedule.{userId}.{reportId}', fn ($user, $userId, $reportId): bool => (int) $user->id === (int) $userId
    && Report::whereUserId($userId)->where('id', $reportId)->exists());

Broadcast::channel('App.Models.LocationError.{userId}.{type}', fn ($user, $userId, $reportId): bool => (int) $user->id === (int) $userId);
