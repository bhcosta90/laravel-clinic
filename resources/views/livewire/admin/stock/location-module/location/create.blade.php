@php use App\Enums\Models\Location; @endphp
<div>
    <x-button :text="__('Create New Location')" wire:click="$toggle('modal')" outline/>

    <x-modal size="3xl" :title="__('Create New Location')" wire>
        <form id="module-create" wire:submit="save" class="space-y-3">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <x-select.sector
                    wire:model="sector_id"
                    required
                />

                <x-input type="number" :label="__('Temperature')" wire:model="temperature"/>
            </div>



            <div class="space-y-3 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-lg p-4 sm:p-5">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ __('Address Range') }}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <x-input type="number" :label="__('Initial Column') . ' *'" required min="0" wire:model="column_initial"/>
                    <x-input type="number" :label="__('Final Column') . ' *'" required min="0" wire:model="column_final"/>
                    <div class="sm:col-span-2 text-xs text-gray-500 dark:text-gray-400">{{ __('Maximum difference of 25 between initial and final column.') }}</div>

                    <x-input type="number" :label="__('Initial Level') . ' *'" required min="0" wire:model="level_initial"/>
                    <x-input type="number" :label="__('Final Level') . ' *'" required min="0" wire:model="level_final"/>
                    <div class="sm:col-span-2 text-xs text-gray-500 dark:text-gray-400">{{ __('Maximum difference of 25 between initial and final level.') }}</div>

                    <x-input type="number" :label="__('Initial Position') . ' *'" required min="0" wire:model="position_initial"/>
                    <x-input type="number" :label="__('Final Position') . ' *'" required min="0" wire:model="position_final"/>
                    <div class="sm:col-span-2 text-xs text-gray-500 dark:text-gray-400">{{ __('Maximum difference of 25 between initial and final position.') }}</div>
                </div>
            </div>

            <div class="space-y-3 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-lg p-4 sm:p-5">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ __('Attributes') }}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <x-ui.select.enum wire:model="type" :label="__('Address Type') . ' *'" required :enum="Location\Type::class" />
                    <x-ui.select.enum wire:model="control" :label="__('Control Type')" :enum="Location\Control::class" />
                    <x-ui.select.enum wire:model="zone" :label="__('Zone') . ' *'" required :enum="Location\Zone::class" />
                    <x-ui.select.enum wire:model="status" :label="__('Status') . ' *'" required :enum="Location\Status::class" />
                </div>
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="module-create" class="w-full sm:w-auto">
                @lang('Register the address blocks')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
