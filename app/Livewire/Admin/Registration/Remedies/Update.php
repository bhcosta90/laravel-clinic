<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Remedies;

use App\Livewire\Traits\Alert;
use App\Models\Remedy;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Update extends Component
{
    use Alert;

    public ?Remedy $remedy = null;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.registration.remedies.update');
    }

    #[On('load::remedy')]
    public function load(Remedy $remedy): void
    {
        $this->remedy = $remedy;

        $this->modal = true;
    }

    public function rules(): array
    {
        return [
            'remedy.name'        => ['required', 'string', 'max:255'],
            'remedy.quantity'    => ['nullable', 'string', 'max:255'],
            'remedy.description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->remedy->save();

        $this->dispatch('updated');

        $this->resetExcept('remedy');

        $this->success();
    }
}
