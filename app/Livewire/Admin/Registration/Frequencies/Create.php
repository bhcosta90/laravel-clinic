<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Frequencies;

use App\Livewire\Traits\Alert;
use App\Models\Procedure;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Create extends Component
{
    use Alert;

    public Procedure $procedure;

    public bool $modal = false;

    public function mount(): void
    {
        $this->procedure = new Procedure();
    }

    public function render(): View
    {
        return view('livewire.admin.registration.frequencies.create');
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

        $this->procedure->save();

        $this->dispatch('created');

        $this->reset();
        $this->procedure = new Procedure();

        $this->success();
    }
}
