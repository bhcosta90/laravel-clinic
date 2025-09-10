<?php

declare(strict_types = 1);

namespace App\Models;

final class RoomUnavailability extends Eloquent\Model
{
    protected $fillable = [
        'room_id',
        'start_at',
        'end_at',
        'reason',
    ];
}
