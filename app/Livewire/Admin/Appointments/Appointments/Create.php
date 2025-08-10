<?php

declare(strict_types = 1);

namespace App\Livewire\Admin\Appointments\Appointments;

use App\Models\Agreement;
use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Procedure;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

final class Create extends Component
{
    public bool $modal;

    public array $dataAppointment = [];

    public ?Appointment $appointment = null;

    public function mount(): void
    {
        $this->appointment = new Appointment();
    }

    public function updatedModal(): void
    {
        $this->appointment = new Appointment([
            'user_id' => $this->dataAppointment['user_id'] ?? null,
        ]);
    }

    public function render(): View
    {
        return view('livewire.admin.appointments.appointments.create');
    }

    public function rules(): array
    {
        return [
            'appointment.customer_id'          => ['required', Rule::exists(Customer::class, 'id')],
            'appointment.procedure_id'         => ['required', Rule::exists(Procedure::class, 'id')],
            'appointment.agreement_id'         => ['nullable', Rule::exists(Agreement::class, 'id')],
            'appointment.exam_withdrawal_date' => ['nullable', 'string', 'max:100'],
            'appointment.description'          => ['nullable', 'string', 'max:100'],
            'appointment.is_return'            => ['nullable', 'boolean'],
            'dataAppointment.user_id'          => ['required', Rule::exists(User::class, 'id')->where('is_employee', true)],
            'dataAppointment.date'             => ['required', 'date', 'after_or_equal:today'],
            'dataAppointment.time'             => ['required', 'date_format:H:i', Rule::in($this->times())],
        ];
    }

    #[Computed(persist: true)]
    public function times(): array
    {
        $start    = config('date.hour_start', 8);
        $end      = config('date.hour_end', 18);
        $interval = config('date.interval_minutes', 15);

        $times = [];

        for ($hour = $start; $hour < $end; ++$hour) {
            for ($minute = 0; $minute < 60; $minute += $interval) {
                $times[] = sprintf('%02d:%02d', $hour, $minute);
            }
        }

        return $times;
    }

    public function save(): void
    {
        $data = $this->validate();

        $this->appointment->date    = now()->parse($data['dataAppointment']['date'] . ' ' . $data['dataAppointment']['time']);
        $this->appointment->user_id = $data['dataAppointment']['user_id'];
        $this->appointment->save();

        $this->resetExcept('dataAppointment');
        $this->dataAppointment['time'] = null;
        $this->dispatch('created');
    }

    #[On('customer::created')]
    public function syncCustomer(int $customerId): void
    {
        $this->appointment->customer_id = $customerId;
    }
}
