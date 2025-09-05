<div>
    @if($modal)
        <x-ui.action size="3xl" :title="__('Update Frequency: #:id', ['id' => $form->model?->id])">
            <form id="frequency-update-{{ $form->model?->id }}" wire:submit="save" class="space-y-4">
                <x-admin.registration.frequencies.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="frequency-update-{{ $form->model?->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-ui.action>
    @endif
</div>
