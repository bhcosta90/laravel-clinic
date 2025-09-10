<?php

declare(strict_types = 1);

namespace App\Services\Domain\Scheduling;

use App\Models\Appointment;
use App\Models\Insurance;
use App\Models\Patient;
use Carbon\Carbon;

final class ConstraintsService
{
    public function adjustMinDate(Patient $patient, Carbon $minDate): Carbon
    {
        $insurer = $this->patientInsurer($patient);

        if ($insurer && !is_null($insurer->min_days_in_advance)) {
            $minDate = $minDate->copy()->max(now()->addDays((int) $insurer->min_days_in_advance));
        }

        if ($insurer && !is_null($insurer->max_monthly_appointments)) {
            $startOfMonth = $minDate->copy()->startOfMonth();
            $endOfMonth   = $minDate->copy()->endOfMonth();
            $count        = Appointment::query()
                ->where('patient_id', $patient->id)
                ->whereBetween('start_at', [$startOfMonth, $endOfMonth])
                ->count();

            if ($count >= (int) $insurer->max_monthly_appointments) {
                $minDate = $minDate->copy()->addMonthNoOverflow()->startOfMonth();
            }
        }

        if ($insurer && !is_null($insurer->max_appointments_per_patient_month)) {
            $startOfMonth = $minDate->copy()->startOfMonth();
            $endOfMonth   = $minDate->copy()->endOfMonth();
            $patientMonth = Appointment::query()
                ->where('patient_id', $patient->id)
                ->whereBetween('start_at', [$startOfMonth, $endOfMonth])
                ->count();

            if ($patientMonth >= (int) $insurer->max_appointments_per_patient_month) {
                $minDate = $minDate->copy()->addMonthNoOverflow()->startOfMonth();
            }
        }

        return $minDate;
    }

    public function insurer(Patient $patient): ?Insurance
    {
        return Insurance::query()
            ->join('patient_insurance', 'insurances.id', '=', 'patient_insurance.insurance_id')
            ->where('patient_insurance.patient_id', $patient->id)
            ->where('patient_insurance.active', true)
            ->select('insurances.*')
            ->first();
    }

    private function patientInsurer(Patient $patient): ?Insurance
    {
        return $this->insurer($patient);
    }
}
