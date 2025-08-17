<div>
    @if($modal)
        <x-modal size="4xl" :title="__('Update '.mb_ucfirst($this->form->type->label()).': #:id', ['id' => $this->form->model->id])" wire>
            <form id="transaction-update-{{ $this->form->model->id }}" wire:submit="save" class="space-y-4">
                <x-admin.financial.transactions.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="transaction-update-{{ $this->form->model->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-modal>
    @endif
</div>
