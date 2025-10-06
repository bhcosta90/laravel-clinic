<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

final class DoctorRequest extends FormRequest
{
    /**
     * @return array<string, array<Password|string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'crm' => ['required'],
            'password' => ['nullable', Password::default()],
        ];
    }
}
