<?php

declare(strict_types = 1);

namespace App\Http\Requests\Admin\V1\Api\Location;

use App\Enums\Models\Location as LocationEnum;
use App\Models\Location;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::exists(Location::class)->where('tenant_id', auth()->user()->tenant_id),
            ],
            'type'             => ['required', Rule::enum(LocationEnum\Type::class)],
            'aisle'            => ['nullable', 'string', 'max:10'],
            'column'           => ['nullable', 'string', 'max:10'],
            'level'            => ['nullable', 'string', 'max:10'],
            'position'         => ['nullable', 'string', 'max:10'],
            'zone'             => ['required', Rule::enum(LocationEnum\Zone::class)],
            'location_type'    => ['required', Rule::enum(LocationEnum\Zone::class)],
            'max_capacity'     => ['nullable', 'numeric', 'max:4000000000'],
            'picking_sequence' => ['nullable', 'numeric', 'max:4000000000'],
            'control'          => ['required', Rule::enum(LocationEnum\Control::class)],
            'temperature'      => ['nullable', 'numeric'],
            'status'           => ['required', Rule::enum(LocationEnum\Status::class)],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
