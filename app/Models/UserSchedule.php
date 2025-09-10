<?php

declare(strict_types = 1);

namespace App\Models;

final class UserSchedule extends Eloquent\Model
{
    protected $fillable = [
        'user_id',
        'day_of_week',
        'start_time',
        'end_time',
        'slot_minutes',
    ];
}
