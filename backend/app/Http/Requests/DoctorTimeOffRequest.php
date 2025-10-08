<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class DoctorTimeOffRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'doctor_id' => ['required', 'exists:doctors'],
            'start_at' => ['required', 'date', 'date_format:Y-m-d H:i'],
            'end_at' => ['required', 'date', 'date_format:Y-m-d H:i'],
            'reason' => ['required'],
        ];
    }
}
