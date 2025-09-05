<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Roles;

use App\Livewire\Traits\Alert;
use App\Models\Role;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

final class Create extends Component
{
    use Alert;

    public Role $role;

    public bool $slide = false;

    public function mount(): void
    {
        $this->role = new Role();
    }

    public function render(): View
    {
        return view('livewire.admin.registration.roles.create');
    }

    public function rules(): array
    {
        return [
            'role.name' => [
                'required',
                'string',
                'max:255',
            ],
            'role.nested_parent' => [
                'nullable',
                Rule::exists(Role::class, 'id'),
            ],
        ];
    }

    public function save(): void
    {
        $this->validate();

        if ($this->role->nested_parent) {
            $role = Role::find($this->role->nested_parent);
            $role->appendNode($this->role);
        } else {
            $this->role->save();
        }

        $this->dispatch('created');

        $this->reset();
        $this->role = new Role();

        $this->success();
    }
}
