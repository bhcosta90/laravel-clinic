<?php

declare(strict_types = 1);

namespace App\Models;

final class RoomSchedule extends Eloquent\Model
{
    protected $fillable = [
        'room_id',
        'day_of_week',
        'start_time',
        'end_time',
        'slot_minutes',
    ];
}
