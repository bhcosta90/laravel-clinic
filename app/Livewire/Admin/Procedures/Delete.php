<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Procedures;

use App\Livewire\Traits\Alert;
use App\Models\Procedure;
use App\Services\ProcedureService;
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
        app(ProcedureService::class)->delete($this->procedure);

        $this->dispatch('deleted');

        $this->success();
    }
}
