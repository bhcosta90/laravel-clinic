<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use App\Models\Specialty;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class SpecialtyRequest extends FormRequest
{
    public function rules(): array
    {
        $isRequired = Rule::requiredIf(fn () => blank($this->route('specialty')));

        return [
            'code' => [Rule::unique(Specialty::class)->ignore($this->route('specialty'))],
            'name' => [$isRequired],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
