<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\People\Users;

use App\Livewire\Traits\Alert;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

final class Impersonate extends Component
{
    use Alert;

    public User $user;

    public function render(): string
    {
        return <<<'HTML'
        <div>
            <x-button.circle color="yellow" icon="user" wire:click="exec" />
        </div>
        HTML;
    }

    public function exec(): void
    {
        Cache::set('impersonate_actual', auth()->id());
        Cache::set('impersonate_new', $this->user->id);

        $this->redirect(route('admin.dashboard'));
    }
}
