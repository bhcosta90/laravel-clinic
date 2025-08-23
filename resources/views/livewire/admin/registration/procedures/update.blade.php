<div>
    @if($modal)
        <x-modal size="3xl" :title="__('Update Procedure: #:id', ['id' => $procedure?->id])" wire>
            <form id="procedure-update-{{ $procedure?->id }}" wire:submit="save" class="space-y-4">
                <x-admin.registration.procedures.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="procedure-update-{{ $procedure?->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-modal>
    @endif
</div>
