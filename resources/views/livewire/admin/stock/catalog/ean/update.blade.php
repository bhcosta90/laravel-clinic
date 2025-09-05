<div>
    @if($modal)
        <x-modal size="3xl" :title="__('Update Ean: #:id', ['id' => $this->form->model?->id])" wire>
            <form id="catalog-ean-create" wire:submit="save" class="space-y-4">
                <x-admin.stock.catalog.ean.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="catalog-ean-create">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-modal>
    @endif
</div>
