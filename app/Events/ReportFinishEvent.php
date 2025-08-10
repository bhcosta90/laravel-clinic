<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

class ReportFinishEvent implements ShouldBroadcastNow
{
    use Dispatchable;

    public function __construct(public int $reportId)
    {
    }

    public function broadcastOn()
    {
        return new Channel('report');
    }
}
