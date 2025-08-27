<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Triage;

use App\Models\Frequency;
use App\Services\FrequencyService;

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
            app(FrequencyService::class)->handle('update', $this->model, $data);

            return $this->model;
        }

        return app(FrequencyService::class)->handle('store', $data);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'days' => ['required', 'numeric', 'min:0'],
        ];
    }
}
