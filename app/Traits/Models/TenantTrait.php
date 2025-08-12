<?php

declare(strict_types = 1);

namespace App\Traits\Models;

trait TenantTrait
{
    protected static function bootTenantTrait(): void
    {
        static::creating(function ($model): void {
            $model->tenant_id = auth()->user()->tenant_id;
        });
    }
}
