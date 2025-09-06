<div>
    @if($slide)
        <x-ui.action size="3xl" :title="__('Update Triage: #:id', ['id' => $form->model?->hash_code])">
            <form id="triage-update-{{ $form->model?->hash_code }}" wire:submit="save" class="space-y-4">
                <x-admin.triage.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="triage-update-{{ $form->model?->hash_code }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-ui.action>
    @endif
</div>
