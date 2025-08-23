@php use App\Enums\Models\Appointment\Status;use App\Models\Appointment; @endphp
<div>
    <x-card>
        <x-slot:header>
            <x-ui.header title="Appointments"/>
        </x-slot:header>

        <div class="p-4 bg-gray-50 dark:bg-gray-900 rounded-lg mb-6">
            <div class="flex flex-col md:flex-row gap-6 items-end">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 flex-1">
                    <x-ui.date
                        :label="__('Date')"
                        wire:model.live="date"
                        required
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700"
                    />

                    <x-select.styled
                        :label="__('Employee')"
                        wire:model.live="user_id"
                        :request="[
                            'url' => route('admin.v1.api.user.search'),
                            'params' => ['(is_employee,=)' => true],
                        ]"
                        class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700"
                    />

                    <div class="relative">
                        <!-- Empty space for future filters -->
                    </div>
                </div>
                <div class="mb-2">
                    @can('create', Appointment::class)
                        <livewire:admin.appointments.appointments.create @created="$refresh"
                                                                         :dataAppointment="['user_id' => $this->user_id, 'date' => $this->date]"/>
                        <livewire:admin.people.customers.create :show-button="false"/>
                    @endcan
                </div>
            </div>
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden border border-gray-200 dark:border-gray-700">
            <x-table :headers="$this->headers" :$sort :rows="$this->rows" loading>
                @interact('column_hour', $row)
                <div class="w-0 font-medium text-blue-600 dark:text-blue-400">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $row->date->format('H:i') }}
                    </div>
                </div>
                @endinteract

                @interact('column_created_at', $row)
                <x-ui.created_at :date="$row->created_at" />
                @endinteract

                @interact('column_customer_name', $row)
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-secondary-500 mr-1" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <div class="text-gray-500 dark:text-dark-300 font-medium">{{ $row->customer->name }} <span
                            class="text-xs text-gray-600 dark:text-dark-400">({{ $row->customer->birthday_description }})</span></div>
                </div>
                @endinteract

                @interact('column_procedure_name', $row)
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 mr-1" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <div>
                        <span class="font-medium text-gray-500 dark:text-dark-300">{{ $row->procedure->name }}</span>
                        <span class="text-xs ml-1 text-gray-600 dark:text-dark-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="inline h-3 w-3" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ $row->user->name }}
                        </span>
                    </div>
                </div>
                <div>
                    @if($row->status === Status::Confirmed)
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full flex items-center w-fit">
                            @lang($row->status_description)
                        </span>
                    @else
                        <span class="px-2 py-1 text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200 rounded-full flex items-center w-fit">
                            @lang($row->status_description)
                        </span>
                    @endif

                </div>
                @endinteract

                @interact('column_is_return', $row)
                @if($row->is_return)
                    <span
                        class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full dark:bg-purple-900 dark:text-purple-200 flex items-center w-fit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            @lang('Yes')
                        </span>
                @endif
                @endinteract

                @interact('column_action', $row)
                <div class="flex gap-2 justify-end">
                    <div class="flex gap-1">
                        @can('executePayment', $row)
                            <livewire:admin.appointments.appointments.execute-payment :appointment="$row"
                                                                                      :key="uniqid('', true)"
                                                                                      @deleted="$refresh"/>
                        @endcan
                        @can('delete', $row)
                            <livewire:admin.appointments.appointments.delete :appointment="$row" :key="uniqid('', true)"
                                                                             @deleted="$refresh"/>
                        @endcan
                    </div>
                </div>
                @endinteract

                <x-slot name="footer">
                    {{ $this->rows->links('tallstack-ui::components.table.paginators', ['simplePagination' => true]) }}
                </x-slot>
            </x-table>
        </div>
    </x-card>
</div>
