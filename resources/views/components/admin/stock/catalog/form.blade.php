@php use App\Enums\Models\Catalog; @endphp
<div class="space-y-3">
    <x-input label="{{ __('Name') }} *" wire:model="form.name" required :placeholder="__('e.g., Pharmacy Sector')" />
    <x-ui.select.enum label="{{ __('Unit of measure') }} *" wire:model="form.sku_code" required :enum="Catalog\Level::class" />
    <x-input label="{{ __('SKU') }} *" wire:model="form.sku_code" required :placeholder="__('Unique code for this sector')" />
    <x-ui.select.enum
        wire:model="form.tracking_mode"
        :label="__('Tracking mode') . ' *'"
        required
        :enum="Catalog\TrackingMode::class"
    />

    <x-ui.select.enum
        wire:model="form.status"
        :label="__('Status') . ' *'"
        required
        :enum="Catalog\Status::class"
    />

    <x-ui.select.enum
        wire:model="form.hazardous"
        :label="__('Hazardous')"
        :enum="Catalog\Hazardous::class"
    />
</div>
