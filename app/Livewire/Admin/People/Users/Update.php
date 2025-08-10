<?php

declare(strict_types=1);

namespace App\Livewire\Admin\People\Users;

use App\Livewire\Traits\Alert;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Update extends Component
{
    use Alert;

    public Form $form;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.people.users.update');
    }

    #[On('load::user')]
    public function load(User $user): void
    {
        $this->form->setModel($user);

        $this->modal = true;
    }

    public function save(): void
    {
        $this->form->save();

        $this->dispatch('updated');

        $this->resetExcept('form');

        $this->success();
    }
}
