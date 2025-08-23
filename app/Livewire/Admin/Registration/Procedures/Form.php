<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\Procedures;

use App\Models\Procedure;
use App\Services\ProcedureService;

final class Form extends \Livewire\Form
{
    public ?Procedure $model = null;

    public $name;
    public $price;
    public $time;
    public $description;
    public $is_agreement;
    public $is_exam;

    public function setModel(Procedure $model): void
    {
        $this->model        = $model;
        $this->name         = $model->name;
        $this->price        = $model->price;
        $this->time         = $model->time;
        $this->description  = $model->description;
        $this->is_agreement = $model->is_agreement;
        $this->is_exam      = $model->is_exam;
    }

    public function save(): Procedure
    {
        $data = $this->validate();

        if ($this->model?->id) {
            app(ProcedureService::class)->handle('update', $this->model, $data);

            return $this->model;
        }

        return app(ProcedureService::class)->handle('store', $data);
    }

    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:255'],
            'price'        => ['required', 'numeric', 'min:0'],
            'time'         => ['required', 'integer', 'min:1'],
            'description'  => ['nullable', 'string', 'max:1000'],
            'is_agreement' => ['nullable', 'boolean'],
            'is_exam'      => ['nullable', 'boolean'],
        ];
    }
}
