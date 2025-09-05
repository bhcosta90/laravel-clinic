<div>
    @if($slide)
        <x-ui.action size="3xl" :title="__('Update Triage: #:id', ['id' => $form->model?->id])">
            <form id="triage-update-{{ $form->model?->id }}" wire:submit="save" class="space-y-4">
                <x-admin.triage.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="triage-update-{{ $form->model?->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-ui.action>
    @endif
</div>
