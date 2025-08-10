<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Permission;
use App\Models\Role;

final class UpdatingSlugObserver
{
    public function saved(Permission | Role $model): void
    {
        if ($model->slug) {
            return;
        }

        $fullName = $model->name;
        $slug     = str()->slug($model->name);

        if ($model->parent) {
            $slug     = $model->parent->slug . '_' . $slug;
            $fullName = $model->parent->full_name . ' - ' . $fullName;
        }

        $model->full_name = $fullName;
        $model->slug      = str_replace('-', '_', $slug);
        $model->save();
    }
}
