<div>
    @if($slide)
        <x-ui.action size="3xl" :title="__('Update Catalog: #:id', ['id' => $form->model?->id])">
            <form id="catalog-update" wire:submit="save" class="space-y-4">
                <x-admin.stock.catalog.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="catalog-update" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-ui.action>
    @endif
</div>
