<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

class ReportFinishEvent implements ShouldBroadcastNow
{
    use Dispatchable;

    public function __construct(public int $reportId, public int $userId)
    {
    }

    public function broadcastOn()
    {
        // Broadcast to the authenticated user's private channel
        return new PrivateChannel('App.Models.User.' . $this->userId);
    }
}
