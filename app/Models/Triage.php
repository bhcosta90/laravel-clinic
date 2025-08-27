<?php

declare(strict_types = 1);

namespace App\Models;

use App\Enums\Models\Triage\RiskClassification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Triage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'risk_classification',
        'description',
        'mmhg',
        'bpm',
        'irpm',
        'temperature',
        'saturation',
        'allergies',
        'current_medication',
        'history_diseases',
        'time_symptom_onset',
        'general_condition',
        'eva',
    ];

    protected $casts = [
        'risk' => RiskClassification::class,
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
