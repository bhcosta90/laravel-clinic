<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Rooms;

use App\Models\Room;
use App\Services\RoomService;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

final class Form extends Component
{
    public bool $slide   = false;
    public bool $created = false;
    public ?Room $model  = null;

    public function render(): View
    {
        return view('livewire.admin.rooms.form');
    }

    #[On('load::room::create')]
    public function create(): void
    {
        $this->slide = true;
        $this->model = new Room();
    }

    #[On('load::room::update')]
    public function update(Room $room): void
    {
        $this->slide = true;
        $this->model = $room;
    }

    public function save(): void
    {
        $this->validate();
        $this->model->id
            ? app(RoomService::class)->update($this->model, $this->model->toArray())
            : app(RoomService::class)->store($this->model->toArray());

        $this->dispatch('saved');
        $this->reset('slide');
        $this->model = new Room();
    }

    public function rules(): array
    {
        return [
            'model.code'      => ['required', Rule::unique(Room::class, 'code')->ignore($this->model)],
            'model.name'      => ['required', 'max:100'],
            'model.is_active' => ['required', 'boolean'],
        ];
    }
}
