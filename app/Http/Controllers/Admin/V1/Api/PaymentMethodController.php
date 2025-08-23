<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin\V1\Api;

use App\Models\PaymentMethod;
use App\Services\PaymentMethodService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

final class PaymentMethodController
{
    public function search(Request $request)
    {
        $search = $request->get('search');
        $field  = $request->get('field', 'name');

        return app(PaymentMethodService::class)
            ->handle('index', null, [
                $field . ',like' => $search,
            ])
            ->when($request->get('selected'), fn (Builder $query) => $query->whereIn('id', json_decode((string) $request->get('selected'))))
            ->unless($search, fn (Builder $query) => $query->limit(10))
            ->orderBy('name')
            ->get()
            ->map(fn (PaymentMethod $user): array => [
                'label' => $user->{$field},
                'value' => $user->id,
            ]);
    }
}
