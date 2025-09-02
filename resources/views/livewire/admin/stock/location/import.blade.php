<div>
    <x-button type="button" onclick="document.getElementById('importFileInput').click();" outline color="secondary">
        {{ __('Import from template') }}
    </x-button>
    <div style="display:none">
        <x-input type="file" id="importFileInput" wire:model="file" />
    </div>
</div>
