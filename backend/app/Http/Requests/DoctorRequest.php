<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class DoctorRequest extends FormRequest
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
