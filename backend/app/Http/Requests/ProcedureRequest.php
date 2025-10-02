<?php

declare(strict_types = 1);

namespace App\Http\Requests;

use App\Models\Procedure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ProcedureRequest extends FormRequest
{
    public function rules(): array
    {
        $isRequired = Rule::requiredIf(fn () => blank($this->route('search')));

        return [
            'code'                 => [Rule::unique(Procedure::class)->ignore($this->route('search'))],
            'name'                 => [$isRequired],
            'min_duration_minutes' => [
                $isRequired,
                'integer',
                'min:1',
                'max:1440',
                'regex:/^[0-9]+$/',
                'not_in:0',
            ],
            'max_duration_minutes' => [
                $isRequired,
                'integer',
                'min:1',
                'max:1440',
                'regex:/^[0-9]+$/',
                'not_in:0',
                'gt:min_duration_minutes',
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
