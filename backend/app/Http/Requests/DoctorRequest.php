<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class DoctorRequest extends FormRequest
{
    public function rules(): array
    {
        $id = $this->route('doctor') ?: $this->route('user');

        return [
            'user_id' => ['required', Rule::unique(User::class)->ignore($id)],
            'name' => ['required'],
            'crm' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
