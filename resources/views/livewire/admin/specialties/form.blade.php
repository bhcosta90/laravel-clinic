<div class="space-y-4">
    @if($created)
        <x-ui.button wire:click="$dispatch('load::specialty::create')" text="Create new specialty" outline />
    @endif

    <x-ui.slide.form :model="$model" title="specialty">
        <x-ui.input wire:model="model.code" label="Code" placeholder="Enter specialty code" />
        <x-ui.input wire:model="model.name" label="Name" placeholder="Enter specialty name" />
    </x-ui.slide.form>
</div>
