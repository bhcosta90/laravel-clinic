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

    public function __construct(public string $userId, public int $reportId)
    {
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('App.Models.ReportSchedule.' . mb_trim($this->userId) . '.' . $this->reportId);
    }
}
