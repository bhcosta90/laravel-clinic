<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\LocationModule;

use App\Livewire\Traits\Alert;
use App\Models\LocationModule;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Update extends Component
{
    use Alert;

    public Form $form;

    public bool $slide = false;

    public function render(): View
    {
        return view('livewire.admin.stock.location-module.update');
    }

    #[On('load::module')]
    public function load(LocationModule $module): void
    {
        $this->form->setModel($module);
        $this->slide = true;
    }

    public function save(): void
    {
        $model = $this->form->save();

        $this->dispatch('updated');

        $this->form->setModel($model);

        $this->success();
        $this->resetExcept('form');
    }
}
