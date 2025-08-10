<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\People\User;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

final class RemoveImpersonate extends Component
{
    public function render(): View
    {
        return view('livewire.admin.people.user.remove-impersonate');
    }

    public function exec(): void
    {
        $data = ['impersonate_actual', 'impersonate_new'];

        foreach ($data as $key) {
            Cache::purge($key);
            Cache::delete($key);
        }

        $this->redirectRoute('admin.dashboard');
    }
}
