<div>
    @if($this->showButton)
        <x-button :text="__('Create New Catalog')" wire:click="$toggle('slide')" outline />
    @endif

    <x-ui.action size="3xl" :title="__('Create New Catalog')">
        <form id="catalog-create-{{ $id = str()->uuid() }}" wire:submit="save" class="space-y-4">
            <x-admin.stock.catalog.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="catalog-create-{{ $id }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-ui.action>
</div>
