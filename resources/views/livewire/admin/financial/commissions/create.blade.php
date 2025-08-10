<div>
    <x-button :text="__('Create New Commission')" wire:click="$toggle('modal')" outline />

    <x-modal size="3xl" :title="__('Create New Commission')" wire>
        <form id="commission-create" wire:submit="save" class="space-y-4">
            <x-admin.financial.commissions.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="commission-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
