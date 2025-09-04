@php use App\Enums\Models\Location; @endphp
<div>
    <x-button :text="__('Create New Location')" wire:click="$toggle('modal')" outline/>

    <x-modal size="3xl" :title="__('Create New Module')" wire>
        <form id="module-create" wire:submit="save" class="space-y-4">
            <x-select.location-module
                wire:model="location_module_id"
                required
            />

            <div class="grid grid-cols-2 gap-x-3">
                <x-input type="number" :label="__('Initial Column')" min="0" wire:model="column_initial"/>
                <x-input type="number" :label="__('Final Column')" min="0" wire:model="column_final"/>

                <div class="col-span-2 text-sm text-gray-500 p-0 m-0 border-none bg-transparent mb-3">
                    {{ __('May have a maximum of 25 the initial column for the final') }}
                </div>

                <x-input type="number" :label="__('Initial Level')" min="0" wire:model="level_initial"/>
                <x-input type="number" :label="__('Final Level')" min="0" wire:model="level_final"/>

                <div class="col-span-2 text-sm text-gray-500 p-0 m-0 border-none bg-transparent mb-3">
                    {{ __('May have a maximum of 25 the initial level to the final') }}
                </div>

                <x-input type="number" :label="__('Initial Position')" min="0" wire:model="position_initial"/>
                <x-input type="number" :label="__('Final Position')" min="0" wire:model="position_final"/>

                <div class="col-span-2 text-sm text-gray-500 p-0 m-0 border-none bg-transparent mb-3">
                    {{ __('May have a maximum of 25 the starting position for the final') }}
                </div>
            </div>
            <div class="gap-3 grid grid-cols-2">
                <x-ui.select.enum :label="__('Address Type') . ' *'" required :enum="Location\Type::class" />
                <x-ui.select.enum :label="__('Control Type')" :enum="Location\Control::class" />
                <x-ui.select.enum :label="__('Status'). ' *'" required :enum="Location\Status::class" />
                <x-ui.select.enum :label="__('Zone') . ' *'" required :enum="Location\Zone::class" />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="module-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
