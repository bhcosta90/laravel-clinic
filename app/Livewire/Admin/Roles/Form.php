<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Roles;

use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

final class Form extends Component
{
    public bool $slide   = false;
    public bool $created = false;
    public ?Role $model  = null;

    public function render(): View
    {
        return view('livewire.admin.roles.form');
    }

    #[On('load::role::create')]
    public function create(): void
    {
        $this->slide = true;
        $this->model = new Role();
    }

    #[On('load::role::update')]
    public function update(Role $role): void
    {
        $this->slide = true;
        $this->model = $role;
    }

    public function save(): void
    {
        $this->validate();
        $this->model->id
            ? app(RoleService::class)->update($this->model, $this->model->toArray())
            : app(RoleService::class)->store($this->model->toArray());

        $this->dispatch('saved');
        $this->reset('slide');
        $this->model = new Role();
    }

    public function rules(): array
    {
        return [
            'model.code'      => ['required', Rule::unique(Role::class, 'code')->ignore($this->model)],
            'model.name'      => ['required', 'max:100'],
            'model.is_active' => ['required', 'boolean'],
        ];
    }
}
