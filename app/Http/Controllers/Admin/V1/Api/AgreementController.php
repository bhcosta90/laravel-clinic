<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin\V1\Api;

use App\Models\Agreement;
use App\Services\AgreementService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class AgreementController
{
    public function search(Request $request)
    {
        $search = $request->get('search');
        $field  = $request->get('field', 'name');

        $results = app(AgreementService::class)
            ->handle('index', null, [
                $field . ',like' => $search,
            ])
            ->when($request->get('selected'), fn (Builder $query) => $query->whereIn('id', json_decode((string) $request->get('selected'))))
            ->unless($search, fn (Builder $query) => $query->limit(10))
            ->orderBy('name')
            ->get()
            ->map(fn (Agreement $user): array => [
                'label' => $user->{$field},
                'value' => $user->id,
            ]);

        if ($request->has('is_particular') && $request->get('is_particular')) {
            $results->prepend([
                'label' => __('Particular'),
                'value' => 'particular',
            ]);
        }

        return $results;
    }
}
