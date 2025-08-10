<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\AnamnesisGroup;

use App\Livewire\Traits\Alert;
use App\Models\AnamnesisGroup;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Create extends Component
{
    use Alert;

    public AnamnesisGroup $anamnesisGroup;

    public bool $modal = false;

    public function mount(): void
    {
        $this->anamnesisGroup = new AnamnesisGroup();
    }

    public function render(): View
    {
        return view('livewire.admin.registration.anamnesis-group.create');
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

        $this->dispatch('created');

        $this->reset();
        $this->anamnesisGroup = new AnamnesisGroup();

        $this->success();
    }
}
