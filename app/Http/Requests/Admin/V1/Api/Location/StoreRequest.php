<?php

declare(strict_types = 1);

namespace App\Http\Requests\Admin\V1\Api\Location;

use App\Enums\Models\Location as LocationEnum;
use App\Models\Location;
use App\Rules\TenantUnique;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'data' => ['required', 'array', 'min:1'],

            'data.*.code' => [
                'required',
                'string',
                'max:255',
                new TenantUnique(Location::class, 'code'),
            ],
            'data.*.type'             => ['required', Rule::enum(LocationEnum\Type::class)],
            'data.*.aisle'            => ['nullable', 'string', 'max:10'],
            'data.*.column'           => ['nullable', 'string', 'max:10'],
            'data.*.level'            => ['nullable', 'string', 'max:10'],
            'data.*.position'         => ['nullable', 'string', 'max:10'],
            'data.*.zone'             => ['required', Rule::enum(LocationEnum\Zone::class)],
            'data.*.location_type'    => ['required', Rule::enum(LocationEnum\Zone::class)],
            'data.*.max_capacity'     => ['nullable', 'numeric', 'max:4000000000'],
            'data.*.picking_sequence' => ['nullable', 'numeric', 'max:4000000000'],
            'data.*.control'          => ['nullable', Rule::enum(LocationEnum\Control::class)],
            'data.*.temperature'      => ['nullable', 'numeric'],
            'data.*.status'           => ['required', Rule::enum(LocationEnum\Status::class)],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
