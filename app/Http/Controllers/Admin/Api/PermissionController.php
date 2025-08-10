<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Api;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use QuantumTecnology\ControllerBasicsExtension\Builder\BuilderQuery;

final class PermissionController
{
    public function search(Request $request)
    {
        $type   = $request->get('type', 'users');
        $id     = $request->get('id');
        $search = $request->get('search');

        return app(BuilderQuery::class)
            ->execute(new Permission(), [], [
                '(full_name,like)' => $search,
            ])
            ->when($request->get('selected'), fn (Builder $query) => $query->whereIn('id', json_decode((string) $request->get('selected'))))
            ->when($type, function ($query) use ($type, $id): void {
                $query->whereDoesntHave($type, function ($query) use ($id): void {
                    $query->when($id, function ($query) use ($id): void {
                        $query->where('model_id', $id);
                    });
                });
            })
            ->unless($search, fn (Builder $query) => $query->limit(10))
            ->orderBy('name')
            ->get()
            ->map(fn (Permission $user): array => [
                'label' => $user->full_name,
                'value' => $user->id,
            ]);
    }
}
