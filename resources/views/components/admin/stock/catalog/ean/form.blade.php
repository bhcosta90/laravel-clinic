@php use App\Enums\Models\Ean\UnitOfMeasure; @endphp
<div class="space-y-4">
    <div class="space-y-3 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-lg p-4 sm:p-5">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <x-input class="sm:col-span-2" label="{{ __('EAN') }} *" wire:model="form.ean" required placeholder="{{ __('e.g. 7891234567890') }}" />
            <x-ui.select.enum :label="__('Unit of measure') . ' *'" wire:model="form.unit_of_measure" required :enum="UnitOfMeasure::class" />
        </div>
        <div class="sm:col-span-2 text-xs text-gray-500 dark:text-gray-400">{{ __('Provide the product barcode (EAN) and select the unit of measure used for this package.') }}</div>
    </div>

    <x-input type="number" wire:model="form.conversion_factor" :label="__('Conversion factor') . ' *'" />

    <div class="space-y-3 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-lg p-4 sm:p-5">
        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ __('Physical attributes') }}</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <x-input type="number" inputmode="decimal" step="0.001" min="0" label="{{ __('Gross weight') }}" wire:model="form.gross_weight" placeholder="0.000" />
            <x-input type="number" inputmode="decimal" step="0.001" min="0" label="{{ __('Net weight') }}" wire:model="form.net_weight" placeholder="0.000" />
            <x-input type="number" inputmode="decimal" step="0.001" min="0" label="{{ __('Volume') }}" wire:model="form.volume" placeholder="0.000" />
        </div>
        <div class="sm:col-span-2 text-xs text-gray-500 dark:text-gray-400">{{ __('Weights in kilograms and volume in cubic meters, when available.') }}</div>
    </div>

</div>
