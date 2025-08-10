<?php

use App\Models\Report;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (string) $user->id === (string) $id;
});


Broadcast::channel('App.Models.Report.{userId}.{reportId}', function ($user, $userId, $reportId) {
    return (string) $user->id === (string) $userId
        && Report::whereUserId($userId)->where('id', $reportId)->exists();
});
