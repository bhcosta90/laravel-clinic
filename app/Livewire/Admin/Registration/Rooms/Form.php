<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Rooms;

use App\Models\Room;
use App\Services\RoomService;

final class Form extends \Livewire\Form
{
    public ?Room $model = null;

    public $name;

    public function setModel(Room $model): void
    {
        $this->model = $model;
        $this->name  = $model->name;
    }

    public function save(): Room
    {
        $data = $this->validate();

        if ($this->model?->id) {
            app(RoomService::class)->handle('update', $this->model, $data);

            return $this->model;
        }

        return app(RoomService::class)->handle('store', $data);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:240'],
        ];
    }
}
