<div>
    @if($slide)
        <x-ui.action size="3xl" :title="__('Update Patient: #:id', ['id' => $this->form->model?->hash_code])">
            <form id="customer-update-{{ $this->form->model?->hash_code }}" wire:submit="save" class="space-y-4">
                <x-admin.people.customers.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="customer-update-{{ $this->form->model?->hash_code }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-ui.action>
    @endif
</div>
