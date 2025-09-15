<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Permission;

use App\Models\Enums\Permission\Can;
use App\Models\Permission;
use App\Services;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Livewire\Component;

final class SyncPermission extends Component
{
    public ?Model $model = null;

    public function mount(): void
    {
        $this->model = match (request()->route('type')) {
            'user'  => app(Services\UserService::class)->showByCode(request()->route('hash')),
            'role'  => app(Services\RoleService::class)->showByCode(request()->route('hash')),
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

        $permission = Permission::firstOrCreate([
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

        foreach (Can::cases() as $permission) {
            $key[] = Permission::firstOrCreate([
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
                $permissionIds[] = Permission::firstOrCreate([
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
            [$parent, $child, $action, $singleKey] = [null, null, null, '__single__'];

            if (count($parts) >= 3) {
                $parent = __(array_shift($parts));
                $child  = __(array_shift($parts));
                $action = __(implode(' ', $parts));
            } elseif (count($parts) === 2) {
                $parent = __($parts[0]);
                $child  = $singleKey;
                $action = __($parts[1]);
            } else {
                $parent = __('misc');
                $child  = $singleKey;
                $action = __($permission->value);
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
