<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Frequencies;

use App\Models\Frequency;

final class Form extends \Livewire\Form
{
    public ?Frequency $model = null;

    public $name;
    public $days;

    public function setModel(Frequency $model): void
    {
        $this->model = $model;
        $this->name  = $model->name;
        $this->days  = $model->days;
    }

    public function save(): Frequency
    {
        $data = $this->validate();

        if ($this->model?->id) {
            $this->model->fill($data);
            $this->model->save();

            return $this->model;
        }

        $model = new Frequency();
        $model->fill($data);
        $model->save();

        return $model;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'days' => ['required', 'numeric', 'min:0'],
        ];
    }
}
