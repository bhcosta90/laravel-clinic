<div>
    <x-button :text="__('Create New Payment Method')" wire:click="$toggle('modal')" outline />

    <x-modal size="3xl" :title="__('Create New Payment Method')" wire>
        <form id="payment-create" wire:submit="save" class="space-y-4">
            <x-admin.registration.payment-methods.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="payment-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
