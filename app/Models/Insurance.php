<?php

declare(strict_types = 1);

namespace App\Models;

final class Insurance extends Eloquent\Model
{
    protected $fillable = [
        'name',
        'min_days_in_advance',
        'max_monthly_appointments',
        'max_total_appointments',
        'allowed_weekdays',
        'max_appointments_per_patient_month',
    ];

    protected $casts = [
        'allowed_weekdays' => 'array',
    ];
}
