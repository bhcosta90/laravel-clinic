<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Rooms;

use App\Models\Room;

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
            $this->model->fill($data);
            $this->model->save();

            return $this->model;
        }

        $model = new Room();
        $model->fill($data);
        $model->save();

        return $model;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
