<div class="space-y-4">
    <x-input label="{{ __('Name') }} *" wire:model="anamnesisItem.name" required />
    <x-select.styled
        :label="__('Anamnesis Group')"
        wire:model="anamnesisItem.anamnesis_group_id"
        :request="[
            'url' => route('admin.v1.api.anamnesis-group.search'),
        ]"
        unfiltered
    />
    <x-input label="{{ __('Description') }}" wire:model="anamnesisItem.description" required />
</div>
