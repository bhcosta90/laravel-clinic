<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Agreements;

use App\Livewire\Traits\Alert;
use App\Models\Agreement;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Update extends Component
{
    use Alert;

    public ?Agreement $agreement = null;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.registration.agreements.update');
    }

    #[On('load::agreement')]
    public function load(Agreement $agreement): void
    {
        $this->agreement = $agreement;

        $this->modal = true;
    }

    public function rules(): array
    {
        return [
            'agreement.name'       => ['required', 'string', 'max:255'],
            'agreement.cellphone'  => ['required', 'string', 'max:150'],
            'agreement.commission' => ['required', 'numeric:', 'min:0', 'max:100'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->agreement->save();

        $this->dispatch('updated');

        $this->resetExcept('agreement');

        $this->success();
    }
}
