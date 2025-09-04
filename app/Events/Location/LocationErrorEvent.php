<?php

declare(strict_types = 1);

namespace App\Events\Location;

use App\Enums\Models\Error\Type;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;

final class LocationErrorEvent implements ShouldBroadcastNow
{
    use Dispatchable;

    public function __construct(public int $userId, public Type $type)
    {
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('App.Models.LocationError.' . $this->userId . '.' . $this->type->value);
    }
}
