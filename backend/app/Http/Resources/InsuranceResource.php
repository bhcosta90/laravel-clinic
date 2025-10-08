<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Insurance;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Insurance */
final class InsuranceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'min_days_in_advance' => $this->min_days_in_advance,
            'max_monthly_appointments' => $this->max_monthly_appointments,
            'max_total_appointments' => $this->max_total_appointments,
            'allowed_weekdays' => $this->allowed_weekdays,
            'max_appointments_per_patient_month' => $this->max_appointments_per_patient_month,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
