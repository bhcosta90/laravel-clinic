<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Registration\AnamnesisGroup;

use App\Livewire\Traits\Alert;
use App\Models\AnamnesisGroup;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

final class Update extends Component
{
    use Alert;

    public ?AnamnesisGroup $anamnesisGroup = null;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.registration.anamnesis-group.update');
    }

    #[On('load::agreement')]
    public function load(AnamnesisGroup $agreement): void
    {
        $this->anamnesisGroup = $agreement;

        $this->modal = true;
    }

    public function rules(): array
    {
        return [
            'anamnesisGroup.name'        => ['required', 'string', 'max:255'],
            'anamnesisGroup.description' => ['required', 'string', 'max:255'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->anamnesisGroup->save();

        $this->dispatch('updated');

        $this->resetExcept('agreement');

        $this->success();
    }
}
