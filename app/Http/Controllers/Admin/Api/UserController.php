<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Api;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class UserController
{
    public function search(Request $request)
    {
        $search = $request->get('search');
        $field  = $request->get('field', 'name');

        return app(BuilderQuery::class)
            ->execute(new User(), [], [
                '(' . $field . ',like)' => $search,
            ] + request()->all())
            ->unless($search, fn (Builder $query) => $query->limit(10))
            ->when($request->get('selected'), fn (Builder $query) => $query->whereIn('id', json_decode((string) $request->get('selected'))))
            ->orderBy('name')
            ->get()
            ->map(fn (User $user): array => [
                'label' => $user->{$field},
                'value' => $user->id,
            ]);
    }
}
