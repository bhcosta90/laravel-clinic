<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorScheduleRequest extends FormRequest
{
    public function rules(): array
    {
        $isRequired = Rule::requiredIf(fn () => blank($this->route('schedule')));

        return [
            'day_of_week' => [
                $isRequired,
                'string',
                'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            ],
            'start_time' => [
                $isRequired,
                'date_format:H:i',
                'before:end_time',
            ],
            'end_time' => [
                $isRequired,
                'date_format:H:i',
                'after:start_time',
                'before:24:00',
            ],
            'slot_minutes' => [
                $isRequired,
                'integer',
                'min:15',
                'max:120',
                'multiple_of:15',
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
