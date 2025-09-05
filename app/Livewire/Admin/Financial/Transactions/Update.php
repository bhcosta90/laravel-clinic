<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Financial\Transactions;

use App\Enums\Models\Transaction\Type;
use App\Livewire\Traits\Alert;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Update extends Component
{
    use Alert;

    public Form $form;

    public Type $type;

    public bool $slide = false;

    public function render(): View
    {
        return view('livewire.admin.financial.transactions.update');
    }

    #[On('load::transaction')]
    public function load(Transaction $transaction): void
    {
        $this->form->setModel($transaction);

        $this->slide = true;
    }

    public function save(): void
    {
        $this->validate();

        $this->form->save();

        $this->dispatch('updated');

        $this->form->reset();
        $this->reset('slide');

        $this->success();
    }
}
