<div>
    @if($modal)
        <x-ui.action size="3xl" :title="__('Update Patient: #:id', ['id' => $this->form->model?->id])">
            <form id="customer-update-{{ $this->form->model?->id }}" wire:submit="save" class="space-y-4">
                <x-admin.people.customers.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="customer-update-{{ $this->form->model?->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-ui.action>
    @endif
</div>
