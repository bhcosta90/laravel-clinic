@php use App\Models\LocationModule; use App\Enums\Models\Error\Type; @endphp
<div>
    <x-card>
        <x-slot:header>
            <x-ui.header :title="__('Locations')" :subtitle="__('Manage stock locations and their availability status.')">
                <x-slot name="actions">
                    <div class="flex items-center gap-x-3">
                        @can('create', LocationModule::class)
                            <livewire:admin.stock.location-module.location.create :location-module="$locationModule" />
                        @endcan

                        <livewire:admin.stock.location-module.location.order-column :location-module="$locationModule" />
                    </div>
                </x-slot>
            </x-ui.header>
        </x-slot:header>

        <x-table :headers="$this->headers" :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[2, 5, 15, 25]">
            @interact('column_created_at', $row)
                <x-ui.created_at :date="$row->created_at" />
            @endinteract

            @interact('column_status', $row)
                <span class="px-2 py-1 text-xs font-medium rounded-full flex items-center w-fit {{ $row->status->badgeClasses() }}" aria-label="{{ __('Status') }}: {{ $row->status->label() }}">
                    {{ $row->status->label() }}
                </span>
            @endinteract

            @interact('column_type', $row)
                {{ $row->type->label() }}
            @endinteract
        </x-table>
    </x-card>
</div>
