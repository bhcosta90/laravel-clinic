<div>
    @if($modal)
        <x-ui.action :title="__('Update '.mb_ucfirst($this->form->type->label()).': #:id', ['id' => $this->form->model->id])">
            <form id="transaction-update-{{ $this->form->model->id }}" wire:submit="save" class="space-y-4">
                <x-admin.financial.transactions.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="transaction-update-{{ $this->form->model->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-ui.action>
    @endif
</div>
