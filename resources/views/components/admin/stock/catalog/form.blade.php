@php use App\Enums\Models\Catalog; @endphp
<div class="space-y-3">
    <div class="space-y-3 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-lg p-4 sm:p-5">
        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ __('Basic Information') }}</h3>
        <x-input label="{{ __('Name') }} *" wire:model="form.name" required :placeholder="__('e.g., Pharmacy Sector')" />
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <x-ui.select.enum label="{{ __('Unit of measure') }} *" wire:model="form.sku_code" required :enum="Catalog\Level::class" />
            <x-input label="{{ __('SKU') }} *" wire:model="form.sku_code" required :placeholder="__('Unique code for this sector')" />
            <div class="sm:col-span-2 text-xs text-gray-500 dark:text-gray-400">{{ __('Choose a short and descriptive name. The SKU helps to uniquely identify the sector in reports and integrations.') }}</div>
        </div>
    </div>

    <div class="space-y-3 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-lg p-4 sm:p-5">
        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ __('Attributes') }}</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
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

            <div class="sm:col-span-3 space-y-1">
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Tracking mode defines how items in this sector are controlled (lot, serial, expiry, etc.).') }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Hazardous indicates if the sector handles materials that require special care.') }}</p>
            </div>
        </div>
    </div>
</div>
