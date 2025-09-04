@php use App\Enums\Models\Location; @endphp
<div>
    <x-button :text="__('Create New Location')" wire:click="$toggle('modal')" outline/>

    <x-modal size="3xl" :title="__('Create New Location')" wire>
        <form id="module-create" wire:submit="save" class="space-y-6">
            <div class="space-y-2">
                <x-select.location-module
                    wire:model="location_module_id"
                    required
                />
            </div>

            <div class="space-y-3 bg-gray-50 border border-gray-200 rounded-lg p-4 sm:p-5">
                <h3 class="text-sm font-semibold text-gray-700">{{ __('Address Range') }}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <x-input type="number" :label="__('Initial Column')" min="0" wire:model="column_initial"/>
                    <x-input type="number" :label="__('Final Column')" min="0" wire:model="column_final"/>
                    <div class="sm:col-span-2 text-xs text-gray-500">{{ __('Maximum difference of 25 between initial and final column.') }}</div>

                    <x-input type="number" :label="__('Initial Level')" min="0" wire:model="level_initial"/>
                    <x-input type="number" :label="__('Final Level')" min="0" wire:model="level_final"/>
                    <div class="sm:col-span-2 text-xs text-gray-500">{{ __('Maximum difference of 25 between initial and final level.') }}</div>

                    <x-input type="number" :label="__('Initial Position')" min="0" wire:model="position_initial"/>
                    <x-input type="number" :label="__('Final Position')" min="0" wire:model="position_final"/>
                    <div class="sm:col-span-2 text-xs text-gray-500">{{ __('Maximum difference of 25 between initial and final position.') }}</div>
                </div>
            </div>

            <div class="space-y-3 bg-gray-50 border border-gray-200 rounded-lg p-4 sm:p-5">
                <h3 class="text-sm font-semibold text-gray-700">{{ __('Attributes') }}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <x-ui.select.enum :label="__('Address Type') . ' *'" required :enum="Location\Type::class" />
                    <x-ui.select.enum :label="__('Control Type')" :enum="Location\Control::class" />
                    <x-ui.select.enum :label="__('Status') . ' *'" required :enum="Location\Status::class" />
                    <x-ui.select.enum :label="__('Zone') . ' *'" required :enum="Location\Zone::class" />
                </div>
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="module-create" class="w-full sm:w-auto">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
