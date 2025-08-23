<x-admin.report.base-report title="Procedure report" view="pdf.report.procedure">
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
</x-admin.report.base-report>
