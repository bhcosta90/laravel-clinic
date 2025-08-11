@php use App\Enums\Models\Report\Status; @endphp
<x-modal size="4xl" :title="__('Procedure report')" wire>
    <form id="report-{{ $id = str()->uuid() }}" wire:submit="save" class="space-y-6">
        <div class="space-y-3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                <x-ui.date wire:model="date_start" :label="__('Start Date')" />
                <x-ui.date wire:model="date_end" :label="__('End Date')" />
            </div>
        </div>

        <div class="space-y-3">
            <div class="bg-gray-50 p-4 rounded-lg space-y-4">
                <div class="gap-4 grid grid-cols-1 md:grid-cols-2">

                    <x-select.procedure
                        wire:model.live="procedure_id"
                    />
                    <x-select.employee
                        wire:model.live="employee_id"
                        :label="__('Doctor')"
                    />
                </div>
            </div>
        </div>
    </form>

    <livewire:admin.report.status :$report wire:key="report-{{ $report?->id }}" />

    @if($modal)
        <livewire:admin.report.index name="report.procedure" />
    @endif

    <x-slot:footer>
        <x-button type="submit" form="report-{{ $id }}">
            @lang('Generate PDF Report')
        </x-button>
    </x-slot:footer>
</x-modal>
