<?php

declare(strict_types = 1);

namespace App\Models;

final class DoctorUnavailability extends Eloquent\Model
{
    protected $fillable = [
        'doctor_id',
        'start_at',
        'end_at',
        'reason',
    ];
}
