<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Models\Permission\Can;
use App\Models\Appointment;
use App\Models\User;
use App\Policies\Traits\CrudPolicyTrait;

final class AppointmentPolicy
{
    use CrudPolicyTrait;

    public function executePayment(User $user, Appointment $appointment): bool
    {
        return $this->delete($user, $appointment);
    }

    public function generateReport(User $user): bool
    {
        return $user->hasPermissionTo(Can::AppointmentAppointmentReport);
    }

    public function delete(User $user, Appointment $appointment): bool
    {
        return null === $appointment->is_paid && $user->hasPermissionTo($this->getEditPermission());
    }

    protected function getViewPermission(): Can
    {
        return Can::AppointmentAppointmentView;
    }

    protected function getEditPermission(): Can
    {
        return Can::AppointmentAppointmentEdit;
    }
}
