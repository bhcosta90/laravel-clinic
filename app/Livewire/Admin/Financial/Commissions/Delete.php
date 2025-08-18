<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Financial\Commissions;

use App\Models\Commission;

final class Delete extends \App\Abstracts\Livewire\Components\Delete
{
    protected function model(): Commission
    {
        return new Commission();
    }
}
