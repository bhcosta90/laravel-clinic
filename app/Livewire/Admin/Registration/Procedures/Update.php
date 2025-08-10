<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Procedures;

use App\Livewire\Traits\Alert;
use App\Models\Procedure;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Update extends Component
{
    use Alert;

    public ?Procedure $procedure = null;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.registration.procedures.update');
    }

    #[On('load::procedure')]
    public function load(Procedure $procedure): void
    {
        $this->procedure = $procedure;

        $this->modal = true;
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

        $this->dispatch('updated');

        $this->resetExcept('procedure');

        $this->success();
    }
}
