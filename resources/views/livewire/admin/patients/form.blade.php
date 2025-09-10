<div class="space-y-4">
    @if($created)
        <x-ui.button wire:click="$dispatch('load::patient::create')" text="Create new patient" outline />
    @endif

    <x-ui.slide.form :model="$model" title="patient">
        <x-ui.input wire:model="model.code" label="Code" placeholder="Enter patient code" />
        <x-ui.input wire:model="model.name" label="Name" placeholder="Enter patient name" />
    </x-ui.slide.form>
</div>
