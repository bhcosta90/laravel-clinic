<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class RoomTimeOffRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'room_id' => ['required', 'exists:rooms'],
            'start_at' => ['required'],
            'end_at' => ['required'],
            'reason' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
