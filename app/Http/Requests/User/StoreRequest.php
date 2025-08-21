<?php

declare(strict_types = 1);

namespace App\Http\Requests\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

final class StoreRequest extends FormRequest
{
    private ?User $model = null;

    public function setModel(?User $model): void
    {
        $this->model = $model;
    }

    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class, 'email')->ignore($this->model?->id),
            ],
            'cellphone'    => ['nullable', 'max:255'],
            'address'      => ['nullable', 'max:255'],
            'commission'   => ['nullable', 'numeric'],
            'payment_data' => ['nullable', 'string'],
            'role_id'      => ['nullable', Rule::exists(Role::class, 'id')],
            'password'     => [
                'nullable',
                Rule::requiredIf(blank($this->model?->id)),
                Password::default(),
                'confirmed',
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
