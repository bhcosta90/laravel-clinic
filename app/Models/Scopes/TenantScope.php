<?php

declare(strict_types = 1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

final class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $table = $model->getTable();

        if (auth()->check() && $tenantId = auth()->user()->tenant_id) {
            $builder->where($table . '.tenant_id', $tenantId);
        }
    }
}
