<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\AnamnesisGroup;

use App\Models\AnamnesisGroup as AnamnesisGroupModel;

final class Form extends \Livewire\Form
{
    public ?AnamnesisGroupModel $model = null;

    public $name;
    public $description;

    public function setModel(AnamnesisGroupModel $model): void
    {
        $this->model       = $model;
        $this->name        = $model->name;
        $this->description = $model->description;
    }

    public function save(): AnamnesisGroupModel
    {
        $data = $this->validate();

        if ($this->model?->id) {
            $this->model->fill($data);
            $this->model->save();

            return $this->model;
        }

        $model = new AnamnesisGroupModel();
        $model->fill($data);
        $model->save();

        return $model;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ];
    }
}
