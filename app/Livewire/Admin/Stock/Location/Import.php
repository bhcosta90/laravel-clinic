<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Stock\Location;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

final class Import extends Component
{
    use WithFileUploads;

    #[Validate('file|mimes:csv,txt|max:12288')] // 12MB Max
    public $file;

    public function render(): View
    {
        return view('livewire.admin.stock.location.import');
    }
}
