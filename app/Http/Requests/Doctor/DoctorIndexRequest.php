<?php

declare(strict_types = 1);

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

final class DoctorIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_column'    => ['string', 'in:id,name'],
            'order_direction' => ['in:asc,desc'],
        ];
    }
}
