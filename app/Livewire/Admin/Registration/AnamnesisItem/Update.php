<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Registration\AnamnesisItem;

use App\Livewire\Traits\Alert;
use App\Models\AnamnesisGroup;
use App\Models\AnamnesisItem;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

final class Update extends Component
{
    use Alert;

    public ?AnamnesisItem $anamnesisItem = null;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.admin.registration.anamnesis-item.update');
    }

    #[On('load::anamnesisItem')]
    public function load(AnamnesisItem $anamnesisItem): void
    {
        $this->anamnesisItem = $anamnesisItem;

        $this->modal = true;
    }

    public function rules(): array
    {
        return [
            'anamnesisItem.name'               => ['required', 'string', 'max:255'],
            'anamnesisItem.anamnesis_group_id' => ['required', Rule::exists(AnamnesisGroup::class, 'id')],
            'anamnesisItem.description'        => ['nullable', 'string', 'max:255'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->anamnesisItem->save();

        $this->dispatch('updated');

        $this->resetExcept('anamnesisItem');

        $this->success();
    }
}
