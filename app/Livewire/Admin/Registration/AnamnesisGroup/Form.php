<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\AnamnesisGroup;

use App\Models\AnamnesisGroup as AnamnesisGroupModel;
use App\Services\AnamnesisGroupService;

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
            app(AnamnesisGroupService::class)->handle('update', $this->model, $data);

            return $this->model;
        }

        return app(AnamnesisGroupService::class)->handle('store', $data);
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:240'],
            'description' => ['required', 'string', 'max:240'],
        ];
    }
}
