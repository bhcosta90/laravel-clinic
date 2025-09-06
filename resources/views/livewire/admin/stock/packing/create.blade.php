<div>
    @if($this->showButton)
        <x-button :text="__('Create New Packing')" wire:click="$toggle('slide')" outline />
    @endif

    <x-ui.action size="3xl" :title="__('Create New Packing')">
        <form id="packing-create-{{ $id = str()->uuid() }}" wire:submit="save" class="space-y-4">
            <x-admin.stock.packing.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="packing-create-{{ $id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-ui.action>
</div>
