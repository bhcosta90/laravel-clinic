<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Registration\AnamnesisItem;

use App\Livewire\Traits\Alert;
use App\Models\AnamnesisGroup;
use App\Models\AnamnesisItem;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

final class Create extends Component
{
    use Alert;

    public AnamnesisItem $anamnesisItem;

    public bool $modal = false;

    public function mount(): void
    {
        $this->anamnesisItem = new AnamnesisItem();
    }

    public function render(): View
    {
        return view('livewire.admin.registration.anamnesis-item.create');
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

        $this->dispatch('created');

        $this->reset();
        $this->anamnesisItem = new AnamnesisItem();

        $this->success();
    }
}
