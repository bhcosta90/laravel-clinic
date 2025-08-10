<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    \Illuminate\Support\Facades\Log::info('Broadcast auth check', [
        'user_id' => (string) $user->id,
        'channel_id' => (string) $id,
    ]);
    return (string) $user->id === (string) $id;
});
