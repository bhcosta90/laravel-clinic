<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Permission;

use App\Enums\Models\Permission\Can;
use App\Models\Permission as PermissionModel;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

final class SyncPermission extends Component
{
    public User | Role $model;

    public function mount(): void
    {
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

        $permission = PermissionModel::firstOrCreate([
            'slug' => $permissionSlug,
        ]);

        if (!$permission) {
            return;
        }

        if ($hasPermission) {
            $this->model->permissions()->detach($permission->id);
        } else {
            $this->model->permissions()->attach($permission->id);
        }

        $this->model->touch();
    }

    public function assignAllPermissions(): void
    {
        $key = [];

        foreach (Can::cases() as $permission) {
            $key[] = PermissionModel::firstOrCreate([
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
                $permissionIds[] = PermissionModel::firstOrCreate([
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

        foreach (Can::cases() as $permission) {
            $parts = explode('-', $permission->value);

            if (count($parts) >= 3) {
                $parent = __(array_shift($parts));
                $child  = __(array_shift($parts));
                $action = __(implode(' ', $parts));

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
        }

        $permissions = $permissions->sortKeys();

        return $permissions->map(fn ($children) => $children->sortKeys());
    }
}
