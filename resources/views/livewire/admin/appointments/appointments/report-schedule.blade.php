<x-admin.report.base-report title="Scheduling report" view="pdf.report.schedule">
    <div class="space-y-4">
        <div class="bg-gray-50 p-4 rounded-lg space-y-4">
            <div class="gap-4 grid grid-cols-1 md:grid-cols-2">
                <x-select.styled
                    :placeholders="['default' => __('All')]"
                    :options="$this->status()"
                    select="label:name|value:value"
                    :label="__('Status')"
                    wire:model="status"
                />
                <x-select.styled
                    :placeholders="['default' => __('All')]"
                    :options="$this->payed()"
                    select="label:name|value:value"
                    :label="__('Payed')"
                    wire:model="is_payed"
                />
            </div>

            <div class="gap-4 grid grid-cols-1 md:grid-cols-3">
                <x-select.agreement
                    :is-particular="true"
                    wire:model="agreement_id"
                />
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
</x-admin.report.base-report>
