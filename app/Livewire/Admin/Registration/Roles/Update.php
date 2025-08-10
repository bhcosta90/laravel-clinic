<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Registration\Roles;

use App\Livewire\Traits\Alert;
use App\Models\Role;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Update extends Component
{
    use Alert;

    public ?Role $role = null;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.registration.roles.update');
    }

    #[On('load::role')]
    public function load(Role $role): void
    {
        $this->role = $role;

        $this->modal = true;
    }

    public function rules(): array
    {
        return [
            'role.name' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->role->save();

        $this->dispatch('updated');

        $this->resetExcept('role');

        $this->success();
    }
}
