<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Permission;

use App\Models;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;

final class SyncPermission extends Component
{
    public Model | Models\User | Models\Role | null $model = null;

    public function mount(): void
    {
        $hash = request()->route('hash');

        $this->model = match (request()->route('type')) {
            'user'  => Models\User::findOrFail(Models\User::decodeHashCode($hash)),
            'role'  => Models\Role::findOrFail(Models\Role::decodeHashCode($hash)),
            default => throw new Exception('Invalid type'),
        };

        $this->model->load('permissions');
    }

    public function render(): View
    {
        $permissions = $this->getGroupedPermissions();

        return view('livewire.admin.permission.sync-permission', [
            'permissions' => $permissions,
        ]);
    }

    public function togglePermission(string $permissionSlug): void
    {
        $hasPermission = $this->model->permissions->contains('slug', $permissionSlug);

        $permission = Models\Permission::firstOrCreate([
            'slug' => $permissionSlug,
        ]);

        if (!$permission) {
            return;
        }

        $hasPermission
            ? $this->model->permissions()->detach($permission->id)
            : $this->model->permissions()->attach($permission->id);

        $this->model->touch();
    }

    public function assignAllPermissions(): void
    {
        $key = [];

        foreach (Models\Enums\Permission\Can::cases() as $permission) {
            $key[] = Models\Permission::firstOrCreate([
                'slug' => $permission,
            ])->id;
        }

        $this->model->permissions()->sync($key);

        $this->model->load('permissions');
        $this->model->touch();
    }

    public function assignParentPermissions(string $parentName): void
    {
        $permissions       = $this->getGroupedPermissions();
        $parentPermissions = $permissions[$parentName] ?? collect();

        $permissionIds = [];

        foreach ($parentPermissions as $childPermissions) {
            foreach ($childPermissions as $permission) {
                $permissionIds[] = Models\Permission::firstOrCreate([
                    'slug' => $permission['value'],
                ])->id;
            }
        }

        $currentPermissionIds = $this->model->permissions->pluck('id')->toArray();

        $allPermissionIds = array_unique(array_merge($currentPermissionIds, $permissionIds));

        $this->model->permissions()->sync($allPermissionIds);

        $this->model->load('permissions');
        $this->model->touch();
    }

    public function hasPermission(string $permissionSlug): bool
    {
        return $this->model->permissions->contains('slug', $permissionSlug);
    }

    private function getGroupedPermissions(): Collection
    {
        $permissions = collect();

        foreach (Models\Enums\Permission\Can::cases() as $permission) {
            $parts             = explode('::', (string) $permission->value);
            [, , , $singleKey] = [null, null, null, '__single__'];

            if (count($parts) >= 3) {
                $parent = __('permission.' . ucfirst(array_shift($parts)));
                $child  = __('permission.' . ucfirst((string) array_shift($parts)));
                $action = __('permission.' . ucfirst(implode(' ', $parts)));
            } elseif (2 === count($parts)) {
                $parent = __('permission.' . ucfirst($parts[0]));
                $child  = $singleKey;
                $action = __('permission.' . ucfirst($parts[1]));
            } else {
                $parent = __('permission.misc');
                $child  = $singleKey;
                $action = __('permission.' . ucfirst($permission->value));
            }

            if (!$permissions->has($parent)) {
                $permissions[$parent] = collect();
            }

            if (!$permissions[$parent]->has($child)) {
                $permissions[$parent][$child] = collect();
            }

            $permissions[$parent][$child]->push([
                'value' => $permission->value,
                'name'  => $action,
                'case'  => $permission,
            ]);
        }

        return $permissions->sortKeys()->map(fn ($children) => $children->sortKeys());
    }
}
