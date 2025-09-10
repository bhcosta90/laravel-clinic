<div class="space-y-4">
    @if($created)
        <x-ui.button wire:click="$dispatch('load::insurance::create')" text="Create new insurance" outline />
    @endif

    <x-ui.slide.form :model="$model" title="insurance">
        <x-ui.input wire:model="model.name" label="Name" placeholder="Enter insurance name" />
    </x-ui.slide.form>
</div>
