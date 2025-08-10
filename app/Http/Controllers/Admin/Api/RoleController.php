<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Api;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class RoleController
{
    public function search(Request $request)
    {
        $search = $request->get('search');
        $field  = $request->get('field', 'full_name');

        return app(BuilderQuery::class)
            ->execute(new Role(), [], [
                '(' . $field . ',like)' => $search,
            ])
            ->when($request->get('selected'), fn (Builder $query) => $query->whereIn('id', json_decode((string) $request->get('selected'))))
            ->unless($search, fn (Builder $query) => $query->limit(10))
            ->orderBy('name')
            ->get()
            ->map(fn (Role $user): array => [
                'label' => $user->{$field},
                'value' => $user->id,
            ]);
    }
}
