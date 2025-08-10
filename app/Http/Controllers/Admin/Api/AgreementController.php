<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Api;

use App\Models\Agreement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class AgreementController
{
    public function search(Request $request)
    {
        $search = $request->get('search');
        $field  = $request->get('field', 'name');

        return app(BuilderQuery::class)
            ->execute(new Agreement(), [], [
                '(' . $field . ',like)' => $search,
            ])
            ->when($request->get('selected'), fn (Builder $query) => $query->whereIn('id', json_decode((string) $request->get('selected'))))
            ->unless($search, fn (Builder $query) => $query->limit(10))
            ->orderBy('name')
            ->get()
            ->map(fn (Agreement $user): array => [
                'label' => $user->{$field},
                'value' => $user->id,
            ]);
    }
}
