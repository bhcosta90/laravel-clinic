@php use App\Models; @endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="tallstackui_darkTheme()">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="tenant-id" content="{{ auth()->user()->tenant_id }}">
    <tallstackui:script/>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased"
      x-cloak
      x-data="{ name: @js(auth()->user()->name) }"
      x-on:name-updated.window="name = $event.detail.name"
      x-bind:class="{ 'dark bg-gray-800': darkTheme, 'bg-gray-100': !darkTheme }">
<x-layout>
    <x-slot:top>
        <x-dialog/>
        <x-toast/>
    </x-slot:top>
    <x-slot:header>
        <x-layout.header>
            <x-slot:left>
                <x-theme-switch/>
            </x-slot:left>
            <x-slot:right>
                <x-dropdown>
                    <x-slot:action>
                        <div>
                            <button class="cursor-pointer" x-on:click="show = !show">
                                <span class="text-base font-semibold text-primary-500" x-text="name"></span>
                            </button>
                        </div>
                    </x-slot:action>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown.items :text="__('Profile')" :href="route('admin.v1.people.user.profile')"/>
                        <x-dropdown.items :text="__('Logout')"
                                          onclick="event.preventDefault(); this.closest('form').submit();" separator/>
                    </form>
                </x-dropdown>
            </x-slot:right>
        </x-layout.header>
        @if(\Illuminate\Support\Facades\Cache::has('impersonate_actual') && \Illuminate\Support\Facades\Cache::has('impersonate_new'))
            <livewire:admin.people.user.remove-impersonate/>
        @endif
        <livewire:admin.financial.transactions.receipt-agreement.index/>
        <livewire:admin.appointments.appointments.report-schedule/>
        <livewire:admin.appointments.appointments.report-procedure/>
    </x-slot:header>
    <x-slot:menu>
        <x-side-bar smart collapsible>
            <x-slot:brand>
                <div class="mt-8 flex items-center justify-center">
                    <img src="{{ asset('/assets/images/tsui.png') }}" width="40" height="40"/>
                </div>
            </x-slot:brand>
            <x-side-bar.item text="Dashboard" icon="users" :route="route('admin.dashboard')"/>
            <x-side-bar.item :text="__('People')"
                             :visible="
                    auth()->user()->can('viewAny', Models\User::class)
                    || auth()->user()->can('viewEmployeeAny', Models\User::class)
                    || auth()->user()->can('viewAny', Models\Customer::class)
                    || auth()->user()->can('birthday', Models\Customer::class)
                "
            >
                <x-side-bar.item :text="__('Users')" :route="route('admin.v1.people.users.index')"
                                 :visible="auth()->user()->can('viewAny', Models\User::class)"/>

                <x-side-bar.item :text="__('Employees')" :route="route('admin.v1.people.employees.index')"
                                 :visible="auth()->user()->can('viewEmployeeAny', Models\User::class)"/>

                <x-side-bar.item :text="__('Patients')" :route="route('admin.v1.people.customers.index')"
                                 :visible="auth()->user()->can('viewAny', Models\Customer::class)"/>

                <x-side-bar.item :text="__('Birthdays of the month')"
                                 :route="route('admin.v1.people.customers.birthday')"
                                 :visible="auth()->user()->can('birthday', Models\Customer::class)"/>
            </x-side-bar.item>

            <x-side-bar.item :text="__('Registration')"
                             :visible="
                    auth()->user()->can('viewAny', Models\Role::class)
                    || auth()->user()->can('viewAny', Models\Procedure::class)
                    || auth()->user()->can('viewAny', Models\Agreement::class)
                    || auth()->user()->can('viewAny', Models\PaymentMethod::class)
                    || auth()->user()->can('viewAny', Models\Frequency::class)
                    || auth()->user()->can('viewAny', Models\Remedy::class)
                    || auth()->user()->can('viewAny', Models\Room::class)
                    || auth()->user()->can('viewAny', Models\AnamnesisGroup::class)
                    || auth()->user()->can('viewAny', Models\AnamnesisItem::class)
                "
            >
                <x-side-bar.item :text="__('Roles')" :route="route('admin.v1.registration.roles.index')"
                                 :visible="auth()->user()->can('viewAny', Models\Role::class)"/>

                <x-side-bar.item :text="__('Procedures')" :route="route('admin.v1.registration.procedures.index')"
                                 :visible="auth()->user()->can('viewAny', Models\Procedure::class)"/>

                <x-side-bar.item :text="__('Agreements')" :route="route('admin.v1.registration.agreements.index')"
                                 :visible="auth()->user()->can('viewAny', Models\Agreement::class)"/>

                <x-side-bar.item :text="__('Payment Methods')"
                                 :route="route('admin.v1.registration.payment-methods.index')"
                                 :visible="auth()->user()->can('viewAny', Models\PaymentMethod::class)"/>

                <x-side-bar.item :text="__('Frequencies')" :route="route('admin.v1.registration.frequencies.index')"
                                 :visible="auth()->user()->can('viewAny', Models\Frequency::class)"/>

                <x-side-bar.item :text="__('Remedies')" :route="route('admin.v1.registration.remedies.index')"
                                 :visible="auth()->user()->can('viewAny', Models\Remedy::class)"/>

                <x-side-bar.item :text="__('Rooms')" :route="route('admin.v1.registration.rooms.index')"
                                 :visible="auth()->user()->can('viewAny', Models\Room::class)"/>

                <x-side-bar.item :text="__('Anamnesis Group')"
                                 :route="route('admin.v1.registration.anamnesis-group.index')"
                                 :visible="auth()->user()->can('viewAny', Models\AnamnesisGroup::class)"/>

                <x-side-bar.item :text="__('Anamnesis Item')"
                                 :route="route('admin.v1.registration.anamnesis-item.index')"
                                 :visible="auth()->user()->can('viewAny', Models\AnamnesisItem::class)"/>
            </x-side-bar.item>

            <x-side-bar.item :text="__('Financial')"
                             :visible="
                    auth()->user()->can('viewIncomesAny', Models\Transaction::class)
                    || auth()->user()->can('viewExpensesAny', Models\Transaction::class)
                    || auth()->user()->can('viewAny', Models\Commission::class)
                    || auth()->user()->can('sendReceiptAgreement', Models\Transaction::class)
                "
            >
                <x-side-bar.item :text="__('Incomes')"
                                 :route="route('admin.v1.transactions.transactions.index', ['type' => 'incomes'])"
                                 :visible="auth()->user()->can('viewIncomesAny', Models\Transaction::class)"/>

                <x-side-bar.item :text="__('Expenses / Payments')"
                                 :route="route('admin.v1.transactions.transactions.index', ['type' => 'expenses'])"
                                 :visible="auth()->user()->can('viewExpensesAny', Models\Transaction::class)"/>

                <x-side-bar.item :text="__('Commissions')"
                                 :route="route('admin.v1.transactions.commissions.index')"
                                 :visible="auth()->user()->can('viewAny', Models\Commission::class)"/>

                <x-side-bar.item :text="__('Receipt Agreements')"
                                 x-on:click="$dispatch('load::receipt-agreements')"
                                 href="#"
                                 :visible="auth()->user()->can('sendReceiptAgreement', Models\Transaction::class)"/>

            </x-side-bar.item>

            <x-side-bar.item :text="__('Appointments')"
                             :visible="
                    auth()->user()->can('viewAny', Models\Appointment::class)
                    || auth()->user()->can('generateReport', Models\Appointment::class)
                "
            >
                <x-side-bar.item :text="__('Appointments')"
                                 :route="route('admin.v1.appointments.appointments.index')"
                                 :visible="auth()->user()->can('viewAny', Models\Appointment::class)"/>

                @can('viewAny', Models\Appointment::class)
                    <x-side-bar.item :text="__('Scheduling report')"
                                     x-on:click="$dispatch('appointment::appointment::report-schedule')"
                                     href="#"
                    />

                    <x-side-bar.item :text="__('Procedure report')"
                                     x-on:click="$dispatch('appointment::appointment::report-procedure')"
                                     href="#"
                    />
                @endcan

            </x-side-bar.item>

            @can('viewAny', Models\Triage::class)
                <x-side-bar.item :text="__('Triage')"
                                 :route="route('admin.v1.triage.index')"
                                 :visible="auth()->user()->can('viewAny', Models\Triage::class)"/>
            @endcan

            <x-side-bar.item :text="__('Stock')"
                             :visible="
                    ($location = auth()->user()->can('viewAny', Models\Location::class)
                    || auth()->user()->can('viewAny', Models\LocationModule::class))
                "
            >
                <x-side-bar.item :text="__('Location')"
                                 :visible="
                    $location
                "
                >
                    <x-side-bar.item :text="__('By Import')"
                                     :route="route('admin.v1.stocks.locations.index')"
                                     :visible="auth()->user()->can('viewAny', Models\Location::class)"/>

                    <x-side-bar.item :text="__('By Module')"
                                     :route="route('admin.v1.stocks.locations.modules.index')"
                                     :visible="auth()->user()->can('viewAny', Models\LocationModule::class)"/>
                </x-side-bar.item>
            </x-side-bar.item>

            <x-side-bar.item :text="__('Welcome Page')" icon="arrow-uturn-left" :route="route('welcome')"/>
        </x-side-bar>
    </x-slot:menu>
    {{ $slot }}
</x-layout>
@livewireScripts
</body>
</html>
