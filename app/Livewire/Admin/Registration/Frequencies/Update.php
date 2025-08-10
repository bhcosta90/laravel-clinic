<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Frequencies;

use App\Livewire\Traits\Alert;
use App\Models\Frequency;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Update extends Component
{
    use Alert;

    public ?Frequency $frequency = null;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.registration.frequencies.update');
    }

    #[On('load::frequency')]
    public function load(Frequency $frequency): void
    {
        $this->frequency = $frequency;

        $this->modal = true;
    }

    public function rules(): array
    {
        return [
            'frequency.name' => ['required', 'string', 'max:255'],
            'frequency.days' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->frequency->save();

        $this->dispatch('updated');

        $this->resetExcept('frequency');

        $this->success();
    }
}
