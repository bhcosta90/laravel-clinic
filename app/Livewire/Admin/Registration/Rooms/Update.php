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

    public ?Room $room = null;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.registration.rooms.update');
    }

    #[On('load::room')]
    public function load(Room $room): void
    {
        $this->room = $room;

        $this->modal = true;
    }

    public function rules(): array
    {
        return [
            'room.name' => ['required', 'string', 'max:255'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->room->save();

        $this->dispatch('updated');

        $this->resetExcept('room');

        $this->success();
    }
}
