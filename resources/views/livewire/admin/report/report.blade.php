<div>
    <x-table :headers="$this->headers" :rows="$this->rows" paginate simple-pagination loading>
        @interact('column_status', $row)
            <livewire:admin.report.status :min="true" :report="$row" wire:key="report-status-{{ str()->uuid() }}" />
        @endinteract

        @interact('column_created_at', $row)
            <x-ui.created_at :date="$row->created_at" />
        @endinteract
    </x-table>
</div>
