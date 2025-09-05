<div>
    <x-button :text="__('Create New Ean')" wire:click="$toggle('modal')" outline />

    <x-modal size="4xl" :title="__('Create New Ean')" wire>
        <form id="catalog-ean-create" wire:submit="save" class="space-y-4">
            <x-admin.stock.catalog.ean.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="catalog-ean-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
