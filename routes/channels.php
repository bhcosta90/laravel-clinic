<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', fn ($user, $id): bool => (string) $user->id === (string) $id);

Broadcast::channel('App.Models.ReportSchedule.{userId}', fn ($user, $userId): bool => (string) $user->id === (string) $userId);

Broadcast::channel('App.Models.ReportSchedule.{userId}.{reportId}', fn ($user, $userId, $reportId): bool => (string) $user->id === (string) $userId
);
