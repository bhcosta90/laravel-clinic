<div>
    @if($modal)
        <x-ui.action :title="__('Update Role: #:id', ['id' => $role?->id])">
            <form id="role-update-{{ $role?->id }}" wire:submit="save" class="space-y-4">
                <div>
                    <x-input label="{{ __('Name') }} *" wire:model="role.name" required />
                </div>
            </form>
            <x-slot:footer>
                <x-button type="submit" form="role-update-{{ $role?->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-ui.action>
    @endif
</div>
