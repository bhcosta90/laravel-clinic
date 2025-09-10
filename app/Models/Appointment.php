<?php

declare(strict_types = 1);

namespace App\Models;

final class Appointment extends Eloquent\Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'procedure_id',
        'room_id',
        'start_at',
        'end_at',
    ];
}
