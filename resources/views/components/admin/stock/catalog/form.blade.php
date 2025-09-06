@php use App\Enums\Models\Catalog; @endphp
<div class="space-y-3">
    <div class="space-y-3 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-lg p-4 sm:p-5">
        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ __('Basic Information') }}</h3>
        <x-input label="{{ __('Name') }} *" wire:model="form.name" required :placeholder="__('e.g., Syringe 5ml')" />
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <x-input label="{{ __('SKU') }} *" wire:model="form.sku_code" required :placeholder="__('Unique stock code')" />
            <x-ui.select.enum class="sm:col-span-2" label="{{ __('Unit of measure') }} *" wire:model="form.level" required :enum="Catalog\Level::class" />
            <div class="sm:col-span-2 text-xs text-gray-500 dark:text-gray-400">{{ __('Choose a clear name and a unique SKU to identify the item across the system and integrations.') }}</div>
        </div>
    </div>

    <div class="space-y-3 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-lg p-4 sm:p-5">
        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ __('Attributes') }}</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <x-ui.select.enum
                wire:model="form.tracking_mode"
                :label="__('Tracking mode') . ' *'"
                required
                :enum="Catalog\TrackingMode::class"
            />

            <x-ui.select.enum
                wire:model="form.hazardous"
                :label="__('Hazardous')"
                :enum="Catalog\Hazardous::class"
            />

            <div class="sm:col-span-2 space-y-1">
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Tracking mode defines how this item is controlled (none, lot, serial, expiry).') }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Use Hazardous when the item requires special storage, transport, or handling procedures.') }}</p>
            </div>
        </div>

        <x-ui.select.enum
            wire:model="form.status"
            :label="__('Status') . ' *'"
            required
            :enum="Catalog\Status::class"
        />
    </div>
</div>
