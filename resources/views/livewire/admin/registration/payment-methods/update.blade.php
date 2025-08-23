<div>
    @if($modal)
        <x-modal size="3xl" :title="__('Update Payment Method: #:id', ['id' => $payment?->id])" wire>
            <form id="payment-update-{{ $payment?->id }}" wire:submit="save" class="space-y-4">
                <x-admin.registration.payment-methods.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="payment-update-{{ $payment?->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-modal>
    @endif
</div>
