<div>
    <x-button :text="__('Create New Catalog')" wire:click="$toggle('modal')" outline />

    <x-modal size="3xl" :title="__('Create New Catalog')" wire>
        <form id="catalog-create" wire:submit="save" class="space-y-4">
            <x-admin.stock.catalog.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="catalog-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
