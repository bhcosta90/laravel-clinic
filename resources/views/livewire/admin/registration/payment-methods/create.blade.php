<div>
    <x-button :text="__('Create New Payment Method')" wire:click="$toggle('slide')" outline />

    <x-ui.action size="3xl" :title="__('Create New Payment Method')">
        <form id="payment-create" wire:submit="save" class="space-y-4">
            <x-admin.registration.payment-methods.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="payment-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-ui.action>
</div>
