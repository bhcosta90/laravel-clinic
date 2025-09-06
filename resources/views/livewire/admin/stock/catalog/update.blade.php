<div>
    @if($slide)
        <x-ui.action size="3xl" :title="__('Update Catalog: #:id', ['id' => $this->form->model?->id])">
            <form id="catalog-update-{{ $this->form->model?->id }}" wire:submit="save" class="space-y-4">
                <x-admin.stock.catalog.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="catalog-update-{{ $this->form->model?->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-ui.action>
    @endif
</div>
