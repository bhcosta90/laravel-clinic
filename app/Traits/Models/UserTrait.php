<?php

declare(strict_types = 1);

namespace App\Traits\Models;

trait UserTrait
{
    protected static function bootUserTrait(): void
    {
        static::creating(function ($model): void {
            if (blank($model->user_id) && auth()->check()) {
                $model->user_id = auth()->user()->id;
            }
        });
    }
}
