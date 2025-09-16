<?php

declare(strict_types = 1);

namespace App\Services\Domain\Scheduling;

use Carbon\Carbon;
use Illuminate\Support\Collection;

final class Availability
{
    public function isClinicBlocked(Collection $clinicBlocks, Carbon $start, Carbon $end): bool
    {
        foreach ($clinicBlocks as $b) {
            if (Carbon::parse($b->start_at) < $end && Carbon::parse($b->end_at) > $start) {
                return true;
            }
        }

        return false;
    }

    public function isDoctorAvailable(Collection $doctorBlocks, Collection $appointments, int $docId, Carbon $start, Carbon $end): bool
    {
        $blocks = $doctorBlocks->get($docId, collect());

        foreach ($blocks as $b) {
            $bStart = Carbon::parse($b->start_at);
            $bEnd   = Carbon::parse($b->end_at);

            if ($bStart->betweenIncluded($start, $end) || $bEnd->betweenIncluded($start, $end) || ($bStart->lte($start) && $bEnd->gte($end))) {
                return false;
            }
        }

        $doctorAppointmentsList = $appointments->get($docId, collect());

        foreach ($doctorAppointmentsList as $a) {
            $aStart = Carbon::parse($a->start_at);
            $aEnd   = Carbon::parse($a->end_at);

            if ($aStart->betweenIncluded($start, $end) || $aEnd->betweenIncluded($start, $end) || ($aStart->lte($start) && $aEnd->gte($end))) {
                return false;
            }
        }

        return true;
    }

    public function patientConflicts(Collection $patientAppointments, Carbon $start, Carbon $end): bool
    {
        foreach ($patientAppointments as $a) {
            $aStart = Carbon::parse($a->start_at);
            $aEnd   = Carbon::parse($a->end_at);

            if ($aStart < $end && $aEnd > $start) {
                return true;
            }
        }

        return false;
    }

    public function isRoomAvailable(Collection $roomBlocksByRoom, Collection $appointmentsByRoom, int $roomId, Carbon $start, Carbon $end): bool
    {
        $blocks = $roomBlocksByRoom->get($roomId, collect());

        foreach ($blocks as $b) {
            $bStart = Carbon::parse($b->start_at);
            $bEnd   = Carbon::parse($b->end_at);

            if ($bStart < $end && $bEnd > $start) {
                return false;
            }
        }
        $appts = $appointmentsByRoom->get($roomId, collect());

        foreach ($appts as $a) {
            $aStart = Carbon::parse($a->start_at);
            $aEnd   = Carbon::parse($a->end_at);

            if ($aStart < $end && $aEnd > $start) {
                return false;
            }
        }

        return true;
    }
}
