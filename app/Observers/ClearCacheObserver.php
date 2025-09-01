<?php

declare(strict_types = 1);

namespace App\Observers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

final class ClearCacheObserver
{
    public $id;

    public function saved(Role | User $model): void
    {
        $keyId = $model->getKeyName();

        $key = config('cache.times.permission_prefix') . $model->getTable() . ".{$model->{$keyId}}.permissions";
        Cache::purge($key);
        Cache::forget($key);
    }
}
