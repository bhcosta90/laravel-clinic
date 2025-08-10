<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Registration\Procedures;

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
        return view('livewire.admin.registration.procedures.create');
    }

    public function rules(): array
    {
        return [
            'procedure.name'         => ['required', 'string', 'max:255'],
            'procedure.price'        => ['required', 'numeric', 'min:0'],
            'procedure.time'         => ['required', 'integer', 'min:1'],
            'procedure.description'  => ['nullable', 'string', 'max:1000'],
            'procedure.is_agreement' => ['nullable', 'boolean'],
            'procedure.is_exam'      => ['nullable', 'boolean'],

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
