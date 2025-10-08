<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Insurance extends Model
{
    use HasFactory, SoftDeletes;

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
        'min_days_in_advance' => 'integer',
        'max_monthly_appointments' => 'integer',
        'max_total_appointments' => 'integer',
        'max_appointments_per_patient_month' => 'integer',
    ];
}
