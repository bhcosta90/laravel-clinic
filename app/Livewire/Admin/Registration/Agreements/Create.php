<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Agreements;

use App\Livewire\Traits\Alert;
use App\Models\Agreement;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Create extends Component
{
    use Alert;

    public Agreement $agreement;

    public bool $modal = false;

    public function mount(): void
    {
        $this->agreement = new Agreement();
    }

    public function render(): View
    {
        return view('livewire.admin.registration.agreements.create');
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

        $this->dispatch('created');

        $this->reset();
        $this->agreement = new Agreement();

        $this->success();
    }
}
