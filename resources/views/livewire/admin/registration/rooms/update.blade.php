<div>
    @if($modal)
        <x-modal size="3xl" :title="__('Update Room: #:id', ['id' => $room?->id])" wire>
            <form id="room-update-{{ $room?->id }}" wire:submit="save" class="space-y-4">
                <x-admin.registration.rooms.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="room-update-{{ $room?->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-modal>
    @endif
</div>
