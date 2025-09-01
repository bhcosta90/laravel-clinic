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

        <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-lg mb-4">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600 dark:text-gray-300">
                    @lang('Showing') {{ $this->rows->count() }} @lang('triages')
                </div>
                <div>
                    {{ $this->rows->links('tallstack-ui::components.table.paginators', ['simplePagination' => true]) }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($this->rows as $row)
                @php
                    $border = match($row->risk_classification) {
                        \App\Enums\Models\Triage\RiskClassification::Red => 'border-red-300 dark:border-red-700',
                        \App\Enums\Models\Triage\RiskClassification::Orange => 'border-orange-300 dark:border-orange-700',
                        \App\Enums\Models\Triage\RiskClassification::Yellow => 'border-yellow-300 dark:border-yellow-700',
                        \App\Enums\Models\Triage\RiskClassification::Green => 'border-green-300 dark:border-green-700',
                        \App\Enums\Models\Triage\RiskClassification::Blue => 'border-blue-300 dark:border-blue-700',
                    };

                    $badge = match($row->risk_classification) {
                        \App\Enums\Models\Triage\RiskClassification::Red => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                        \App\Enums\Models\Triage\RiskClassification::Orange => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200',
                        \App\Enums\Models\Triage\RiskClassification::Yellow => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                        \App\Enums\Models\Triage\RiskClassification::Green => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                        \App\Enums\Models\Triage\RiskClassification::Blue => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                    };
                @endphp
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow border-2 {{ $border }} overflow-hidden">
                    <div class="p-4 flex items-start justify-between gap-3">
                        <div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                <x-ui.created_at :date="$row->created_at" />
                            </div>
                            <div class="mt-2 text-gray-700 dark:text-gray-200 whitespace-pre-line">
                                {{ $row->description }}
                            </div>
                        </div>
                        <div>
                            <span class="px-2 py-1 text-xs font-medium rounded-full flex items-center w-fit {{ $badge }}">
                                <span class="mr-1">{{ $row->risk_classification->color() }}</span>
                                {{ $row->risk_classification->label() }}
                            </span>
                        </div>
                    </div>
                    <div class="px-4 pb-4 flex items-center justify-end gap-2 border-t border-gray-100 dark:border-gray-700 pt-3">
                        @can('update', $row)
                            <x-button.circle icon="pencil" wire:click="$dispatch('load::triage', { 'triage' : '{{ $row->id }}'})" />
                        @endcan
                        @can('delete', $row)
                            <livewire:admin.registration.triage.delete :triage="$row" :key="uniqid('', true)" @deleted="$refresh" />
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $this->rows->links('tallstack-ui::components.table.paginators', ['simplePagination' => true]) }}
        </div>
    </x-card>

    <livewire:admin.registration.triage.update @updated="$refresh" />
</div>
