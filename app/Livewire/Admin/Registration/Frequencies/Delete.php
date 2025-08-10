<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Registration\Frequencies;

use App\Livewire\Traits\Alert;
use App\Models\Procedure;
use Livewire\Attributes\Renderless;
use Livewire\Component;

final class Delete extends Component
{
    use Alert;

    public Procedure $procedure;

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
        $this->procedure->delete();

        $this->dispatch('deleted');

        $this->success();
    }
}
