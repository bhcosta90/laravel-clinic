<div class="space-y-4">
    @if($created)
        <x-ui.button wire:click="$dispatch('load::role::create')" text="Create new role" outline />
    @endif

    <x-ui.slide.form :model="$model" title="role">
        <x-ui.input wire:model="model.code" label="Code" placeholder="Enter role code" />
        <x-ui.input wire:model="model.name" label="Name" placeholder="Enter role name" />
        <x-ui.enable wire:model="model.is_active" label="Status" placeholder="Select role status" />
    </x-ui.slide.form>
</div>
