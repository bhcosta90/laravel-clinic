<div>
    @if($modal)
        <x-modal size="3xl" :title="__('Update Frequency: #:id', ['id' => $frequency?->id])" wire>
            <form id="frequency-update-{{ $frequency?->id }}" wire:submit="save" class="space-y-4">
                <x-admin.registration.frequencies.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="frequency-update-{{ $frequency?->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-modal>
    @endif
</div>
