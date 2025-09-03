@php use App\Models\Location; @endphp
<div>
    <x-card>
        <x-slot:header>
            <x-ui.header :title="__('Locations')">
                <x-slot name="actions">
                    <div class="flex justify-between gap-x-3 items-center">
                        @can('create', Location::class)
                            <livewire:admin.stock.location.create @created="$refresh" />
                        @endcan

                        <x-dropdown>
                            <x-slot:action>
                                <x-button.circle type="button" icon="bars-3" color="secondary" x-on:click="show = !show" aria-controls="dropdown-menu" />
                            </x-slot:action>
                            <x-dropdown.items :text="__('Export the template')" href="{{ route('admin.v1.api.location.download') }}" />
                            <livewire:admin.stock.location.import />
                        </x-dropdown>
                    </div>
                </x-slot>
            </x-ui.header>
        </x-slot:header>

        <x-table :headers="$this->headers" :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[2, 5, 15, 25]">
            @interact('column_created_at', $row)
                <x-ui.created_at :date="$row->created_at" />
            @endinteract

            @interact('column_status', $row)
                <span class="px-2 py-1 text-xs font-medium rounded-full flex items-center w-fit {{ $row->status->badgeClasses() }}">
                    {{ $row->status->label() }}
                </span>
            @endinteract

            @interact('column_type', $row)
                {{ $row->type->label() }}
            @endinteract

            @interact('column_action', $row)
                <div class="flex gap-1 justify-end">
                    @can('update', $row)
                        <x-button.circle icon="pencil" wire:click="$dispatch('load::location', { 'location' : '{{ $row->id }}'})" />
                    @endcan
                    @can('delete', $row)
                        <livewire:admin.stock.location.delete :location="$row" :key="uniqid('', true)" @deleted="$refresh" />
                    @endcan
                </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:admin.stock.location.update @updated="$refresh" />
</div>
