<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Financial\Transactions;

use App\Enums\Models\Transaction\Type;
use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Create extends Component
{
    use Alert;

    public Type $type;

    public Form $form;

    public bool $slide = false;

    public function render(): View
    {
        return view('livewire.admin.financial.transactions.create');
    }

    public function save(): void
    {
        $this->form->type = $this->type;
        $this->form->save();

        $this->dispatch('created');

        $this->form->reset();
        $this->reset('slide');

        $this->success();
    }
}
