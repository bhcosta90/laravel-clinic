<div>
    <x-modal size="3xl" :title="__('Update Agreement: #:id', ['id' => $agreement?->id])" wire>
        <form id="agreement-update-{{ $agreement?->id }}" wire:submit="save" class="space-y-4">
            <x-admin.registration.agreements.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="agreement-update-{{ $agreement?->id }}" loading="save">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
