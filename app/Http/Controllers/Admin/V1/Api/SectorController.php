<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin\V1\Api;

use App\Models\Sector;
use App\Services\SectorService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class SectorController
{
    public function search(Request $request)
    {
        $search = $request->get('search');
        $field  = $request->get('field', 'name');

        return app(SectorService::class)
            ->handle('index', null, [
                $field . ',like' => $search,
            ])
            ->unless($search, fn (Builder $query) => $query->limit(10))
            ->when($request->get('selected'), fn (Builder $query) => $query->whereIn('id', json_decode((string) $request->get('selected'))))
            ->orderBy('name')
            ->get()
            ->map(fn (Sector $user): array => [
                'label' => $user->{$field},
                'value' => $user->id,
            ]);
    }
}
