<div>
    <x-button :text="__('Create New Ean')" wire:click="$toggle('modal')" outline />

    <x-modal size="3xl" :title="__('Create New Ean')" wire>
        <form id="catalog-create" wire:submit="save" class="space-y-4">
            <x-admin.stock.catalog.ean.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="catalog-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
