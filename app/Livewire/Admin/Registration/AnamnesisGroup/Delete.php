<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\AnamnesisGroup;

use App\Livewire\Traits\Alert;
use App\Models\AnamnesisGroup;
use App\Services\AnamnesisGroupService;
use Livewire\Attributes\Renderless;
use Livewire\Component;

final class Delete extends Component
{
    use Alert;

    public AnamnesisGroup $agreement;

    public function render(): string
    {
        return <<<'HTML'
        <div>
            <x-button.circle icon="trash" color="red" wire:click="confirm" />
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
        app(AnamnesisGroupService::class)->handle('delete', $this->agreement);

        $this->dispatch('deleted');

        $this->success();
    }
}
