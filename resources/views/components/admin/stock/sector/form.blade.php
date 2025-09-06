<div class="space-y-4">
    <x-input label="{{ __('Name') }} *" wire:model="form.name" required />
    <x-input label="{{ __('SKU') }} *" wire:model="form.sku_code" required />
    <x-ui.select.enum label="{{ __('Tracking mode') }} *" required />
    <x-ui.select.enum label="{{ __('Status') }} *" required />
    <x-ui.select.enum label="{{ __('Hazardous') }}" />
</div>
