<div>
    @if($modal)
        <x-modal size="3xl" :title="__('Update Sector: #:id', ['id' => $this->form->model?->id])" wire>
            <form id="sector-update-{{ $this->form->model?->id }}" wire:submit="save" class="space-y-4">
                <x-admin.stock.sector.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="sector-update-{{ $this->form->model?->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-modal>
    @endif
</div>
