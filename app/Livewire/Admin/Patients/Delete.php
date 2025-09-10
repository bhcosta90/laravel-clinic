<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Patients;

use App\Livewire\Traits\Alert;
use App\Models\Patient;
use App\Services\PatientService;
use Livewire\Attributes\Renderless;
use Livewire\Component;

final class Delete extends Component
{
    use Alert;

    public Patient $patient;

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
        app(PatientService::class)->delete($this->patient);

        $this->dispatch('deleted');

        $this->success();
    }
}
