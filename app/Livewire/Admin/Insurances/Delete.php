<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Insurances;

use App\Livewire\Traits\Alert;
use App\Models\Insurance;
use App\Services\InsuranceService;
use Livewire\Attributes\Renderless;
use Livewire\Component;

final class Delete extends Component
{
    use Alert;

    public Insurance $Insurance;

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
        app(InsuranceService::class)->delete($this->Insurance);

        $this->dispatch('deleted');

        $this->success();
    }
}
