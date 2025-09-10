<div class="space-y-4">
    @if($created)
        <x-ui.button wire:click="$dispatch('load::room::create')" text="Create new room" outline />
    @endif

    <x-ui.slide.form :model="$model" title="room">
        <x-ui.input wire:model="model.code" label="Code" placeholder="Enter room code" />
        <x-ui.input wire:model="model.name" label="Name" placeholder="Enter room name" />
        <x-ui.enable wire:model="model.is_active" label="Status" placeholder="Select room status" />
    </x-ui.slide.form>
</div>
