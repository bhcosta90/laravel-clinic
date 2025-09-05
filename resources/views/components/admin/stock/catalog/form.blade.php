@php use App\Enums\Models\Catalog; @endphp
<div class="space-y-4">
    <div class="space-y-3 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-lg p-4 sm:p-5">
        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ __('Basic Information') }}</h3>
        <x-input label="{{ __('Name') }} *" wire:model="form.name" required placeholder="{{ __('e.g. Disposable Gloves') }}" />
        <div class="sm:col-span-2 text-xs text-gray-500 dark:text-gray-400">{{ __('Provide a clear product name and its primary barcode for identification.') }}</div>
    </div>

    <div class="space-y-3 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-lg p-4 sm:p-5">
        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ __('Attributes') }}</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <x-ui.select.enum :label="__('Hazardous') . ' *'" wire:model="form.hazardous" required :enum="Catalog\Hazardous::class" />
            <x-ui.select.enum :label="__('Tracking mode') . ' *'" wire:model="form.tracking_mode" required :enum="Catalog\TrackingMode::class" />
            <x-ui.select.enum class="sm:col-span-2" :label="__('Status') . ' *'" wire:model="form.status" required :enum="Catalog\Status::class" />
        </div>
        <div class="sm:col-span-2 text-xs text-gray-500 dark:text-gray-400">{{ __('Choose how this item is tracked and its current availability status.') }}</div>
    </div>
</div>
