<div>
    <x-button :text="__('Create New ' . mb_ucfirst($this->type->label()))" wire:click="$toggle('modal')" outline />

    <x-modal size="4xl" :title="__('Create New ' . mb_ucfirst($this->type->label()))" wire>
        <form id="transaction-create" wire:submit="save" class="space-y-4">
            <x-admin.financial.transactions.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="transaction-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
