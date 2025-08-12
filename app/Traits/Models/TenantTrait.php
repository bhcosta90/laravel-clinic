<?php

declare(strict_types = 1);

namespace App\Traits\Models;

trait TenantTrait
{
    protected static function bootTenantTrait(): void
    {
        static::creating(function ($model): void {
            if (blank($model->tenant_id) && auth()->check()) {
                $model->tenant_id = auth()->user()->tenant_id;
            }
        });
    }
}
