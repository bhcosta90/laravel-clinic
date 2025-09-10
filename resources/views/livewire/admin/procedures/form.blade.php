<div class="space-y-4">
    @if($created)
        <x-ui.button wire:click="$dispatch('load::procedure::create')" text="Create new procedure" outline />
    @endif

    <x-ui.slide.form :model="$model" title="procedure">
        <x-ui.input wire:model="model.code" label="Code" placeholder="Enter procedure code" />
        <x-ui.input wire:model="model.name" label="Name" placeholder="Enter procedure name" />
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-ui.input wire:model="model.min_duration_minutes" label="Min Duration (minutes)" type="number" min="0" placeholder="e.g. 15" />
            <x-ui.input wire:model="model.max_duration_minutes" label="Max Duration (minutes)" type="number" min="0" placeholder="e.g. 60" />
        </div>
    </x-ui.slide.form>
</div>
