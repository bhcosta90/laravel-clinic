<?php

declare(strict_types = 1);

namespace App\Abstracts\Livewire\Components;

use App\Livewire\Traits\Alert;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;
use Livewire\Component;

abstract class Delete extends Component
{
    use Alert;

    public Model $model;

    abstract protected function model(): Model;

    final public function render(): string
    {
        return '<div></div>';
    }

    #[On('delete-confirm')]
    final public function confirm(int $id): void
    {
        $this->model = $this->model()->findOrFail($id);

        $this->question()
            ->confirm(method: 'delete')
            ->cancel()
            ->send();
    }

    final public function delete(): void
    {
        $this->model->delete();

        $this->dispatch('deleted');

        $this->success();
    }
}
