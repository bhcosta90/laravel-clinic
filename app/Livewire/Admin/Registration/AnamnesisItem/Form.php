<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\AnamnesisItem;

use App\Models\AnamnesisItem as AnamnesisItemModel;
use Illuminate\Validation\Rule;
use App\Models\AnamnesisGroup;

final class Form extends \Livewire\Form
{
    public ?AnamnesisItemModel $model = null;

    public $name;
    public $anamnesis_group_id;
    public $description;

    public function setModel(AnamnesisItemModel $model): void
    {
        $this->model               = $model;
        $this->name                = $model->name;
        $this->anamnesis_group_id  = $model->anamnesis_group_id;
        $this->description         = $model->description;
    }

    public function save(): AnamnesisItemModel
    {
        $data = $this->validate();

        if ($this->model?->id) {
            $this->model->fill($data);
            $this->model->save();

            return $this->model;
        }

        $model = new AnamnesisItemModel();
        $model->fill($data);
        $model->save();

        return $model;
    }

    public function rules(): array
    {
        return [
            'name'               => ['required', 'string', 'max:255'],
            'anamnesis_group_id' => ['required', Rule::exists(AnamnesisGroup::class, 'id')],
            'description'        => ['nullable', 'string', 'max:255'],
        ];
    }
}
