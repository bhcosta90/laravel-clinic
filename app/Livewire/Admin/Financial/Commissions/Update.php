<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Financial\Commissions;

use App\Livewire\Traits\Alert;
use App\Models\Commission;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Update extends Component
{
    use Alert;

    public Form $form;

    public bool $slide = false;

    public function render(): View
    {
        return view('livewire.admin.financial.commissions.update');
    }

    #[On('load::commission')]
    public function load(Commission $commission): void
    {
        $this->form->setModel($commission);

        $this->slide = true;
    }

    public function save(): void
    {
        $this->form->save();

        $this->dispatch('updated');

        $this->resetExcept('form');
        $this->form->reset();

        $this->success();
    }
}
