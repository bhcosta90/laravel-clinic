<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Insurances;

use App\Models\Insurance;
use App\Services\InsuranceService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Form extends Component
{
    public bool $slide       = false;
    public bool $created     = false;
    public ?Insurance $model = null;

    public function render(): View
    {
        return view('livewire.admin.insurances.form');
    }

    #[On('load::insurance::create')]
    public function create(): void
    {
        $this->slide = true;
        $this->model = new Insurance();
    }

    #[On('load::insurance::update')]
    public function update(Insurance $insurance): void
    {
        $this->slide = true;
        $this->model = $insurance;
    }

    public function save(): void
    {
        $this->validate();
        $this->model->id
            ? app(InsuranceService::class)->update($this->model, $this->model->toArray())
            : app(InsuranceService::class)->store($this->model->toArray());

        $this->dispatch('saved');
        $this->reset('slide');
        $this->model = new Insurance();
    }

    public function rules(): array
    {
        return [
            'model.name' => ['required', 'max:100'],
        ];
    }
}
