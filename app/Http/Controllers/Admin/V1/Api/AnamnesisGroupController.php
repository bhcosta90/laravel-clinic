<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin\V1\Api;

use App\Models\AnamnesisGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class AnamnesisGroupController
{
    public function search(Request $request)
    {
        $search = $request->get('search');
        $field  = $request->get('field', 'name');

        return app(BuilderQuery::class)
            ->execute(new AnamnesisGroup(), [], [
                '(' . $field . ',like)' => $search,
            ])
            ->when($request->get('selected'), fn (Builder $query) => $query->whereIn('id', json_decode((string) $request->get('selected'))))
            ->unless($search, fn (Builder $query) => $query->limit(10))
            ->orderBy('name')
            ->get()
            ->map(fn (AnamnesisGroup $user): array => [
                'label' => $user->{$field},
                'value' => $user->id,
            ]);
    }
}
