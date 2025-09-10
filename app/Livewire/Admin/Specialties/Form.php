<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Specialties;

use App\Models\Specialty;
use App\Services\SpecialtyService;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

final class Form extends Component
{
    public bool $slide       = false;
    public bool $created     = false;
    public ?Specialty $model = null;

    public function render(): View
    {
        return view('livewire.admin.specialties.form');
    }

    #[On('load::specialty::create')]
    public function create(): void
    {
        $this->slide = true;
        $this->model = new Specialty();
    }

    #[On('load::specialty::update')]
    public function update(Specialty $specialty): void
    {
        $this->slide = true;
        $this->model = $specialty;
    }

    public function save(): void
    {
        $this->validate();
        $this->model->id
            ? app(SpecialtyService::class)->update($this->model, $this->model->toArray())
            : app(SpecialtyService::class)->store($this->model->toArray());

        $this->dispatch('saved');
        $this->reset('slide');
        $this->model = new Specialty();
    }

    public function rules(): array
    {
        return [
            'model.code' => ['required', Rule::unique(Specialty::class, 'code')->ignore($this->model)],
            'model.name' => ['required', 'max:100'],
        ];
    }
}
