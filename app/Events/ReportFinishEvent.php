<?php

declare(strict_types = 1);

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

final class ReportFinishEvent implements ShouldBroadcastNow
{
    use Dispatchable;

    public function __construct(public int $reportId, public string $userId)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('App.Models.ReportSchedule.' . $this->userId),
            new PrivateChannel('App.Models.ReportSchedule.' . $this->userId . '.' . $this->reportId),
        ];
    }
}
