@php use App\Models\Location; use App\Enums\Models\Error\Type; @endphp
<div>
    <x-card>
        <x-slot:header>
            <x-ui.header :title="__('Locations')" :subtitle="__('Manage stock locations and their availability status.')">
                <x-slot name="actions">
                    <div class="flex flex-wrap justify-between gap-2 items-center">
                        @can('export', Location::class)
                            <x-button :text="__('Export the template')" href="{{ route('admin.v1.api.location.download') }}" color="secondary" outline />
                        @endcan
                        @can('import', Location::class)
                            <livewire:admin.stock.location.import />
                        @endcan
                    </div>
                </x-slot>
            </x-ui.header>
        </x-slot:header>

        <livewire:error.index :type="Type::ImportLocation->value" />

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
