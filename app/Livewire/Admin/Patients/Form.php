<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Patients;

use App\Models\Patient;
use App\Services\PatientService;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

final class Form extends Component
{
    public bool $slide     = false;
    public bool $created   = false;
    public ?Patient $model = null;

    public function render(): View
    {
        return view('livewire.admin.patients.form');
    }

    #[On('load::patient::create')]
    public function create(): void
    {
        $this->slide = true;
        $this->model = new Patient();
    }

    #[On('load::patient::update')]
    public function update(Patient $patient): void
    {
        $this->slide = true;
        $this->model = $patient;
    }

    public function save(): void
    {
        $this->validate();
        $this->model->id
            ? app(PatientService::class)->update($this->model, $this->model->toArray())
            : app(PatientService::class)->store($this->model->toArray());

        $this->dispatch('saved');
        $this->reset('slide');
        $this->model = new Patient();
    }

    public function rules(): array
    {
        return [
            'model.code' => ['required', Rule::unique(Patient::class, 'code')->ignore($this->model)],
            'model.name' => ['required', 'max:100'],
        ];
    }
}
