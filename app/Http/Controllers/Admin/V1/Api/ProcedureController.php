<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin\V1\Api;

use App\Models\Procedure;
use App\Services\ProcedureService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class ProcedureController
{
    public function search(Request $request)
    {
        $search = $request->get('search');
        $field  = $request->get('field', 'name');

        return app(ProcedureService::class)
            ->handle('index', null, [
                $field . ',like' => $search,
            ])
            ->unless($search, fn (Builder $query) => $query->limit(10))
            ->when($request->get('selected'), fn (Builder $query) => $query->whereIn('id', json_decode((string) $request->get('selected'))))
            ->orderBy('name')
            ->get()
            ->map(fn (Procedure $user): array => [
                'label' => $user->{$field},
                'value' => $user->id,
            ]);
    }
}
