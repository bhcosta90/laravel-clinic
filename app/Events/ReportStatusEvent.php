<?php

declare(strict_types = 1);

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

final class ReportStatusEvent implements ShouldBroadcastNow
{
    use Dispatchable;

    public function __construct(public int $reportId, public string $userId)
    {
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('App.Models.ReportSchedule.' . $this->userId . '.' . $this->reportId);
    }
}
