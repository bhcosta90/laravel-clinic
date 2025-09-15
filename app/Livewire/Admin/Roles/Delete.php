<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Roles;

use App\Livewire\Traits\Alert;
use App\Models\Role;
use App\Services\RoleService;
use Livewire\Attributes\Renderless;
use Livewire\Component;

final class Delete extends Component
{
    use Alert;

    public Role $role;

    public function render(): string
    {
        return <<<'HTML'
        <div>
            <x-ui.button.circle icon="trash" color="red" wire:click="confirm" />
        </div>
        HTML;
    }

    #[Renderless]
    public function confirm(): void
    {
        $this->question()
            ->confirm(method: 'delete')
            ->cancel()
            ->send();
    }

    public function delete(): void
    {
        app(RoleService::class)->delete($this->role);

        $this->dispatch('deleted');

        $this->success();
    }
}
