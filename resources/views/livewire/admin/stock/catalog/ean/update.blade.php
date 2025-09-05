<div>
    @if($slide)
        <x-ui.action size="3xl" :title="__('Update Ean: #:id', ['id' => $this->form->model?->id])">
            <form id="catalog-ean-create" wire:submit="save" class="space-y-4">
                <x-admin.stock.catalog.ean.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="catalog-ean-create">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-ui.action>
    @endif
</div>
