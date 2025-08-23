<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Rooms;

use App\Livewire\Traits\Alert;
use App\Models\Room;
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
        return view('livewire.admin.registration.rooms.update');
    }

    #[On('load::room')]
    public function load(Room $room): void
    {
        $this->form->setModel($room);
        $this->modal = true;
    }

    public function save(): void
    {
        $model = $this->form->save();

        $this->dispatch('updated');

        $this->form->setModel($model);

        $this->success();
    }
}
