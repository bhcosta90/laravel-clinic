<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Rooms;

use App\Livewire\Traits\Alert;
use App\Models\Room;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Create extends Component
{
    use Alert;

    public Room $room;

    public bool $modal = false;

    public function mount(): void
    {
        $this->room = new Room();
    }

    public function render(): View
    {
        return view('livewire.admin.registration.rooms.create');
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

        $this->dispatch('created');

        $this->reset();
        $this->room = new Room();

        $this->success();
    }
}
