<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Registration\Roles;

use App\Models\Role;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Permission extends Component
{
    public Role $role;

    public function render(): View
    {
        return view('livewire.admin.registration.roles.permission');
    }
}
