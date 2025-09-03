<div>
    <x-dropdown.items type="button" onclick="document.getElementById('importFileInput').click();" outline color="secondary">
        {{ __('Import from template') }}
    </x-dropdown.items>
    <div style="display:none">
        <x-input type="file" id="importFileInput" wire:model.change="file" />
    </div>
</div>
