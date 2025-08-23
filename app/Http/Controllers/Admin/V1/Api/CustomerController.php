<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin\V1\Api;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class CustomerController
{
    public function search(Request $request)
    {
        $search = $request->get('search');
        $field  = $request->get('field', 'name');

        return app(BuilderQuery::class)
            ->execute(new Customer(), [], [
                '(' . $field . ',like)' => $search,
            ])
            ->unless($search, fn (Builder $query) => $query->limit(10))
            ->when($request->get('selected'), fn (Builder $query) => $query->whereIn('id', json_decode((string) $request->get('selected'))))
            ->orderBy('name')
            ->get()
            ->map(fn (Customer $user): array => [
                'label' => $user->{$field},
                'value' => $user->id,
            ]);
    }
}
