<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Packing;

use App\Abstracts\Model;
use App\Livewire\Traits\Alert;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Create extends Component
{
    use Alert;

    public Form $form;

    public Model $model;

    public bool $slide = false;

    public bool $showButton = true;

    public function mount(): void
    {
        $this->form->setRelation($this->model);
    }

    public function render(): View
    {
        return view('livewire.admin.stock.packing.create');
    }

    public function save(): void
    {
        $packing = $this->form->save();

        $this->dispatch('created');
        $this->dispatch('packing::created', $packing->id);

        $this->resetExcept('form', 'showButton');
        $this->form->reset();

        $this->success();
    }

    #[On('packing::open')]
    public function open(): void
    {
        $this->slide = true;
    }
}
