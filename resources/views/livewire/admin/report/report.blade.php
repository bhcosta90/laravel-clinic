<div>
    <x-table :headers="$this->headers" :rows="$this->rows" paginate simple-pagination loading>
        @interact('column_name', $row)
            @lang($row->name)
        @endinteract

        @interact('column_status', $row)
            <livewire:admin.report.status :min="true" :report="$row" wire:key="report-status-{{ str()->uuid() }}" />
        @endinteract

        @interact('column_can_shared', $row)
            <x-checkbox
                id="can_shared-{{ $row->id }}"
                wire:click="toggleCanShared('{{ $row->id }}')"
                :checked="$row->can_shared"
                class="h-5 w-5"
            />
        @endinteract

        @interact('column_created_at', $row)
            <x-ui.created_at :date="$row->created_at" />
        @endinteract
    </x-table>
</div>
