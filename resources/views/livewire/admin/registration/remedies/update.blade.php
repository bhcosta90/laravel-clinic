<div>
    @if($slide)
        <x-ui.action size="3xl" :title="__('Update Remedy #:id', ['id' => $form->model?->id])">
            <form id="remedy-update" wire:submit="save" class="space-y-4">
                <x-admin.registration.remedies.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="remedy-update" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-ui.action>
    @endif
</div>
