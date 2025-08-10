<?php

declare(strict_types = 1);

namespace App\Models;

use App\Abstracts\Model;
use App\Enums\Models\Permission\Can;
use App\Observers\ClearCacheObserver;
use App\Observers\UpdatingSlugObserver;
use App\Traits\Models\NodeTrait;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Cache;

#[ObservedBy([ClearCacheObserver::class, UpdatingSlugObserver::class])]
final class Role extends Model
{
    use NodeTrait;

    protected $fillable = [
        'name',
    ];

    public function permissions(): MorphToMany
    {
        return $this->morphToMany(Permission::class, 'model', $table = 'model_permissions')
            ->withTimestamps()
            ->whereNull($table . '.deleted_at');
    }

    public function hasPermissionTo(string | Can $role): bool
    {
        if ($role instanceof Can) {
            $role = $role->value;
        }

        $permissions = Cache::remember(
            config('cache.times.permission_prefix') . $this->getTable() . ".{$this->id}.permissions",
            config('cache.times.permission_time'),
            function (): array {
                $permissions = $this->permissions->pluck('slug')->toArray();

                foreach ($this->descendants()->with('permissions')->get() as $role) {
                    $permissions = array_merge($permissions, $role->permissions->pluck('slug')->toArray());
                }

                return array_values(array_unique($permissions));
            }
        );

        return in_array($role, $permissions, true);
    }
}
