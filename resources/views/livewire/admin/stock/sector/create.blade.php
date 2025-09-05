<div>
    @if($this->showButton)
        <x-button :text="__('Create New Sector')" wire:click="$toggle('modal')" outline />
    @endif

    <x-ui.action size="3xl" :title="__('Create New Customer')">
        <form id="sector-create-{{ $id = str()->uuid() }}" wire:submit="save" class="space-y-4">
            <x-admin.stock.sector.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="sector-create-{{ $id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-ui.action>
</div>
