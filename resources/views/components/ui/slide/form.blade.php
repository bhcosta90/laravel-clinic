@props(['title'])
@php
    $id = str()->uuid();
    $action = $this->model?->id ? "Updating" : "Creating new";
    $title = __("$action $title");
@endphp

@if($this->slide)
    <div>
        <x-ui.slide {{ $attributes }} wire title="{{ $title }}">
            <form id="form-{{ $id }}" wire:submit="save" class="space-y-4">
                {{ $slot }}
            </form>

            <x-slot:footer>
                <div class="flex justify-between space-x-2 w-full">
                    <x-ui.button icon="check-circle" type="submit" text="Save" form="form-{{ $id }}" loading="save" primary />
                    <x-ui.button icon="x-circle" text="Cancel" wire:click="$toggle('slide')" secondary outline />
                </div>
            </x-slot:footer>
        </x-ui.slide>
    </div>
@else
    <!-- empty -->
@endif
