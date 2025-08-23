<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\People\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Permission extends Component
{
    public User $user;

    public function render(): View
    {
        return view('livewire.admin.people.users.permission');
    }

    public function mount(): void
    {
        $this->user = User::findOrFail(User::decodeHashCode(request()->route('user_hash')));
        $this->authorize('permissions', $this->user);
    }
}
