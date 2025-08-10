<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Financial\Transactions\ReceiptAgreement;

use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Index extends Component
{
    use Alert;

    public Form $form;

    public $modal = false;

    public function render(): View
    {
        return view('livewire.admin.financial.transactions.receipt-agreement.index');
    }

    #[On('load::receipt-agreements')]
    public function load(): void
    {
        $this->modal = true;
    }

    public function save(): void
    {
        $this->form->save();

        $this->dispatch('created');
        $this->dispatch('load::transactions');

        $this->form->reset();
        $this->reset('modal');

        $this->success();
    }
}
