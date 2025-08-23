<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin\V1\Api;

use App\Models\AnamnesisGroup;
use App\Services\AnamnesisGroupService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class AnamnesisGroupController
{
    public function search(Request $request)
    {
        $search = $request->get('search');
        $field  = $request->get('field', 'name');

        return app(AnamnesisGroupService::class)
            ->handle('index', null, [
                $field . ',like' => $search,
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
