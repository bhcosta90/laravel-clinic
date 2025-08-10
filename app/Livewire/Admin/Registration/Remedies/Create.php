<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Registration\Remedies;

use App\Livewire\Traits\Alert;
use App\Models\Remedy;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Create extends Component
{
    use Alert;

    public Remedy $procedure;

    public bool $modal = false;

    public function mount(): void
    {
        $this->procedure = new Remedy();
    }

    public function render(): View
    {
        return view('livewire.admin.registration.remedies.create');
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

        $this->procedure->save();

        $this->dispatch('created');

        $this->reset();
        $this->procedure = new Remedy();

        $this->success();
    }
}
