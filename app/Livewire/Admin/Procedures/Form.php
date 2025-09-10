<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Procedures;

use App\Models\Procedure;
use App\Services\ProcedureService;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

final class Form extends Component
{
    public bool $slide       = false;
    public bool $created     = false;
    public ?Procedure $model = null;

    public function render(): View
    {
        return view('livewire.admin.procedures.form');
    }

    #[On('load::procedure::create')]
    public function create(): void
    {
        $this->slide = true;
        $this->model = new Procedure();
    }

    #[On('load::procedure::update')]
    public function update(Procedure $procedure): void
    {
        $this->slide = true;
        $this->model = $procedure;
    }

    public function save(): void
    {
        $this->validate();
        $this->model->id
            ? app(ProcedureService::class)->update($this->model, $this->model->toArray())
            : app(ProcedureService::class)->store($this->model->toArray());

        $this->dispatch('saved');
        $this->reset('slide');
        $this->model = new Procedure();
    }

    public function rules(): array
    {
        return [
            'model.code'                 => ['required', Rule::unique(Procedure::class, 'code')->ignore($this->model)],
            'model.name'                 => ['required', 'max:100'],
            'model.min_duration_minutes' => ['required', 'min:0'],
            'model.max_duration_minutes' => ['required', 'min:0'],
        ];
    }
}
