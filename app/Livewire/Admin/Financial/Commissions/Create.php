<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Financial\Commissions;

use App\Livewire\Traits\Alert;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

final class Create extends Component
{
    use Alert;

    public Form $form;

    public bool $slide = false;

    public function render(): View
    {
        return view('livewire.admin.financial.commissions.create');
    }

    public function rules(): array
    {
        return [
            'commission.user_id'      => ['required', Rule::exists(User::class, 'id')->where('is_employee', true)],
            'commission.value'        => ['required', 'numeric:', 'min:0'],
            'commission.due_date'     => ['required', 'date', 'after_or_equal:today'],
            'commission.payment_date' => ['nullable', 'date', 'after_or_equal:today'],
        ];
    }

    public function save(): void
    {
        $this->form->save();

        $this->dispatch('created');

        $this->resetExcept('form');
        $this->form->reset();

        $this->success();
    }
}
