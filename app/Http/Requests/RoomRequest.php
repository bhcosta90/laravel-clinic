<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use App\Models\Specialty;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class RoomRequest extends FormRequest
{
    public function rules(): array
    {
        $isRequired = Rule::requiredIf(fn () => blank($this->route('room')));

        return [
            'code'      => [Rule::unique(Specialty::class)->ignore($this->route('room'))],
            'name'      => [$isRequired],
            'is_active' => ['boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
