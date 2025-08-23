<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin\V1\Api;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class UserController
{
    public function search(Request $request)
    {
        $search = $request->get('search');
        $field  = $request->get('field', 'name');

        $filters                   = request()->all();
        $filters[$field . ',like'] = $search;

        return app(UserService::class)
            ->handle('index', null, $filters)
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
