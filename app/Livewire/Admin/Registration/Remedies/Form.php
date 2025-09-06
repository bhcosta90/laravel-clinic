<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Remedies;

use App\Models\Remedy;
use App\Services\RemedyService;

final class Form extends \Livewire\Form
{
    public ?Remedy $model = null;

    public $name;
    public $quantity;
    public $description;

    public function setModel(Remedy $model): void
    {
        $this->model       = $model;
        $this->name        = $model->name;
        $this->quantity    = $model->quantity;
        $this->description = $model->description;
    }

    public function save(): Remedy
    {
        $data = $this->validate();

        if ($this->model?->id) {
            app(RemedyService::class)->handle('update', $this->model, $data);

            return $this->model;
        }

        return app(RemedyService::class)->handle('store', $data);
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:240'],
            'quantity'    => ['nullable', 'string', 'max:240'],
            'description' => ['nullable', 'string', 'max:240'],
        ];
    }
}
