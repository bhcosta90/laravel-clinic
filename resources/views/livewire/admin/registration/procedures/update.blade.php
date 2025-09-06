<div>
    @if($slide)
        <x-ui.action size="3xl" :title="__('Update Procedure: #:id', ['id' => $form->model?->hash_code])">
            <form id="procedure-update" wire:submit="save" class="space-y-4">
                <x-admin.registration.procedures.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="procedure-update" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-ui.action>
    @endif
</div>
