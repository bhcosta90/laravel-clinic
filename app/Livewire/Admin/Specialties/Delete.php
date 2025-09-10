<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Specialties;

use App\Livewire\Traits\Alert;
use App\Models\Specialty;
use App\Services\SpecialtyService;
use Livewire\Attributes\Renderless;
use Livewire\Component;

final class Delete extends Component
{
    use Alert;

    public Specialty $specialty;

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
        app(SpecialtyService::class)->delete($this->specialty);

        $this->dispatch('deleted');

        $this->success();
    }
}
