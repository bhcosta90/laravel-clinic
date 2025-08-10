<?php

declare(strict_types = 1);

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

final class ReportFinishEvent implements ShouldBroadcastNow
{
    use Dispatchable;

    public function __construct(public int $reportId, public string $userId)
    {
    }

    public function broadcastOn(): Channel
    {
        // Broadcast to the authenticated user's private channel
        return new PrivateChannel('App.Models.Report.' . $this->userId . '.' . $this->reportId);
    }
}
