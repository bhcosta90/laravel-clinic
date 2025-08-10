<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Observers\UpdatingSlugObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

#[ObservedBy([UpdatingSlugObserver::class])]
final class Permission extends Model
{
    protected $fillable = [
        'slug',
    ];

    public function roles(): MorphToMany
    {
        return $this->morphedByMany(Role::class, 'model', $table = 'model_permissions')
            ->withTimestamps()
            ->whereNull($table . '.deleted_at');
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'model', $table = 'model_permissions')
            ->withTimestamps()
            ->whereNull($table . '.deleted_at');
    }
}
