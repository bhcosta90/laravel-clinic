<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class InsuranceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'min_days_in_advance' => ['required'],
            'max_monthly_appointments' => ['required'],
            'max_total_appointments' => ['required'],
            'allowed_weekdays' => ['required'],
            'max_appointments_per_patient_month' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
