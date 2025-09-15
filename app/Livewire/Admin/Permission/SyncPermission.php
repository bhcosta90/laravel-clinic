<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Permission;

use App\Models\Enums\Permission\Can;
use App\Models\Permission;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;

final class SyncPermission extends Component
{
    public ?Model $model = null;

    public function mount(): void
    {
        if ('user' === request()->route('type')) {
            $this->model = app(UserService::class)->showByCode(request()->route('hash'));
        }

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

        $permission = Permission::firstOrCreate([
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
            $parts = explode('::', (string) $permission->value);

            if (count($parts) >= 3) {
                // Three-level: parent-child-action (default)
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
            } elseif (2 === count($parts)) {
                // Two-level: parent-action (no child)
                [$parent, $action] = $parts;
                $parent            = __($parent);
                $action            = __($action);

                if (!$permissions->has($parent)) {
                    $permissions[$parent] = collect();
                }

                // Use a synthetic single-level child key to render consistently
                $singleKey = '__single__';

                if (!$permissions[$parent]->has($singleKey)) {
                    $permissions[$parent][$singleKey] = collect();
                }

                $permissions[$parent][$singleKey]->push([
                    'value' => $permission->value,
                    'name'  => $action,
                    'case'  => $permission,
                ]);
            } else {
                // Fallback for unexpected formats: put everything under Misc group
                $parent = __('misc');
                $action = __($permission->value);

                if (!$permissions->has($parent)) {
                    $permissions[$parent] = collect();
                }

                $singleKey = '__single__';

                if (!$permissions[$parent]->has($singleKey)) {
                    $permissions[$parent][$singleKey] = collect();
                }

                $permissions[$parent][$singleKey]->push([
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
