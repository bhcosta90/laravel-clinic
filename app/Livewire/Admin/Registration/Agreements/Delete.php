<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Agreements;

use App\Livewire\Traits\Alert;
use App\Models\Agreement;
use App\Services\AgreementService;
use Livewire\Attributes\Renderless;
use Livewire\Component;

final class Delete extends Component
{
    use Alert;

    public Agreement $agreement;

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
        app(AgreementService::class)->handle('delete', $this->agreement);

        $this->dispatch('deleted');

        $this->success();
    }
}
