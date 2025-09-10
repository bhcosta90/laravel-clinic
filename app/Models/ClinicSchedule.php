<?php

declare(strict_types = 1);

namespace App\Models;

final class ClinicSchedule extends Eloquent\Model
{
    protected $fillable = [
        'day_of_week',
        'start_time',
        'end_time',
        'slot_minutes',
    ];
}
