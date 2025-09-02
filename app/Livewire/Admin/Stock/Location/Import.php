<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Location;

use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use TallStackUi\Traits\Interactions;

final class Import extends Component
{
    use Interactions;
    use WithFileUploads;

    public $file;

    public function render(): View
    {
        return view('livewire.admin.stock.location.import');
    }

    public function updatedFile(): void
    {
        try {
            $this->validate([
                'file' => 'file|mimes:csv,txt|max:12288',
            ]);
        } catch (ValidationException $th) {
            $this->dialog()->error($th->getMessage())->send();
            $this->file = null;
        }
    }
}
