@php use App\Models\Triage; @endphp
<div>
    <x-card>
        <x-slot:header>
            <x-ui.header :title="__('Triage')">
                <x-slot name="actions">
                    @can('create', Triage::class)
                        <livewire:admin.registration.triage.create @created="$refresh" />
                    @endcan
                </x-slot>
            </x-ui.header>
        </x-slot:header>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
            <x-table :headers="$this->headers" :$sort :rows="$this->rows" loading paginate simple-pagination filter :quantity="[5, 15, 25, 50]">
                @interact('column_created_at', $row)
                    <x-ui.created_at :date="$row->created_at" />
                @endinteract

                @interact('column_risk_classification', $row)
                    @php
                        $classes = match($row->risk_classification) {
                            \App\Enums\Models\Triage\RiskClassification::Red => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                            \App\Enums\Models\Triage\RiskClassification::Orange => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
                            \App\Enums\Models\Triage\RiskClassification::Yellow => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                            \App\Enums\Models\Triage\RiskClassification::Green => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                            \App\Enums\Models\Triage\RiskClassification::Blue => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                        };
                    @endphp
                    <span class="px-2 py-1 text-xs font-medium rounded-full flex items-center w-fit {{ $classes }}">
                        <span class="mr-1">{{ $row->risk_classification->color() }}</span>
                        {{ $row->risk_classification->label() }}
                    </span>
                @endinteract

                @interact('column_action', $row)
                    <div class="flex gap-2 justify-end">
                        @can('update', $row)
                            <x-button.circle icon="pencil" wire:click="$dispatch('load::triage', { 'triage' : '{{ $row->id }}'})" />
                        @endcan
                        @can('delete', $row)
                            <livewire:admin.registration.triage.delete :triage="$row" :key="uniqid('', true)" @deleted="$refresh" />
                        @endcan
                    </div>
                @endinteract

                <x-slot name="footer">
                    <div class="mr-4">
                        {{ $this->rows->links('tallstack-ui::components.table.paginators', ['simplePagination' => true]) }}
                    </div>
                </x-slot>
            </x-table>
        </div>
    </x-card>

    <livewire:admin.registration.triage.update @updated="$refresh" />
</div>
