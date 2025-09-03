<?php

declare(strict_types = 1);

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;

trait TenantTrait
{
    protected static function bootTenantTrait(): void
    {
        static::creating(function ($model): void {
            if (blank($model->tenant_id) && auth()->check()) {
                $model->tenant_id = tenant()->id;
            }
        });

        static::addGlobalScope('byTenant', function (Builder $builder): void {
            $table = $builder->getModel()->getTable();

            if (auth()->check() && $tenantId = tenant()->id) {
                $builder->where($table . '.tenant_id', $tenantId);
            }
        });
    }
}
