<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorRequest extends FormRequest
{
    public function rules(): array
    {
        $isRequired = Rule::requiredIf(fn () => blank($this->route('doctor')));

        return [
            'name' => [$isRequired],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
