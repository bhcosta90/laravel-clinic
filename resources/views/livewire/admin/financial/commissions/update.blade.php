<div>
    @if($modal)
        <x-modal size="3xl" :title="__('Update Commission: #:id', ['id' => $this->form->model?->id])" wire>
            <form id="commission-update-{{ $this->form->model?->id }}" wire:submit="save" class="space-y-4">
                <x-admin.financial.commissions.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="commission-update-{{ $this->form->model?->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-modal>
    @endif
</div>
