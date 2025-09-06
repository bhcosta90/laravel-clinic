@php use App\Enums\Models\Catalog; @endphp
<div class="space-y-3">
    <div class="space-y-3 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 sm:p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor"><path d="M2 6a2 2 0 012-2h12a2 2 0 012 2H2zM2 8h16v6a2 2 0 01-2 2H4a2 2 0 01-2-2V8z"/></svg>
            {{ __('Basic Information') }}
        </h3>
        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Provide the item identification details.') }}</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <x-input label="{{ __('Name') }} *" wire:model="form.name" required :placeholder="__('e.g., Syringe 5ml')" />
            <x-input label="{{ __('SKU') }} *" wire:model="form.sku_code" required :placeholder="__('Unique stock code')" />
            <x-ui.select.enum class="sm:col-span-2" label="{{ __('Unit of measure') }} *" wire:model="form.level" required :enum="Catalog\Level::class" />
            <div class="sm:col-span-2 text-xs text-gray-500 dark:text-gray-400">{{ __('Choose a clear name and a unique SKU to identify the item across the system and integrations.') }}</div>
        </div>
    </div>

    <div class="space-y-3 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4 sm:p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor"><path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v3H2V5zm0 5h16v5a2 2 0 01-2 2H4a2 2 0 01-2-2v-5z"/></svg>
            {{ __('Attributes') }}
        </h3>
        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Configure how the item is controlled and any special handling needs.') }}</p>
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

    <x-message.required />
</div>
