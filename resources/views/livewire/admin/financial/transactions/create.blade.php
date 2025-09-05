<div>
    <x-button :text="__('Create New ' . mb_ucfirst($this->type->label()))" wire:click="$toggle('modal')" outline />

    <x-ui.action :title="__('Create New ' . mb_ucfirst($this->type->label()))">
        <form id="transaction-create" wire:submit="save" class="space-y-4">
            <x-admin.financial.transactions.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="transaction-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-ui.action>
</div>
