<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Location;

use App\Enums\Queue\Queue;
use App\Imports\Location\LocationImport;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
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

            $import = new LocationImport();

            Excel::import($import, $this->file->getRealPath())
                ->allOnQueue(Queue::Low);

            $this->dialog()->success(__('Import started successfully. Wait a few moments to see all locations registered in the system'))->send();

        } catch (ValidationException $th) {
            $this->dialog()->error($th->getMessage())->send();
            $this->reset('file');
        }
    }
}
