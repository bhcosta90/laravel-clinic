<?php

declare(strict_types = 1);

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;

trait WarehouseTrait
{
    protected static function bootWarehouseTrait(): void
    {
        static::creating(function ($model): void {
            if (blank($model->warehouse_id) && warehouse()) {
                $model->warehouse_id = warehouse()->id;
            }
        });

        static::addGlobalScope('byWarehouse', function (Builder $builder): void {
            $table = $builder->getModel()->getTable();

            if (auth()->check() && $warehouseId = warehouse()->id) {
                $builder->where($table . '.warehouse_id', $warehouseId);
            }
        });
    }
}
