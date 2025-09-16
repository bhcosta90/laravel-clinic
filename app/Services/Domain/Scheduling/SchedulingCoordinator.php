<?php

declare(strict_types = 1);

namespace App\Services\Domain\Scheduling;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Procedure;
use Illuminate\Support\Collection;

final readonly class SchedulingCoordinator
{
    public function __construct(
        private ConstraintsService $constraints,
        private DataPreloader $preloader,
        private Availability $availability,
        private DoctorSlotFinder $doctorFinder,
        private ClinicSlotFinder $clinicFinder,
        private DoctorSelector $doctorSelector,
        private CoordinatorHelpers $helpers,
    ) {
    }

    public function find(SchedulingRequest $r): Collection
    {
        $patient = Patient::query()->where('code', $r->patientCode)->first();

        if (!$patient) {
            return collect();
        }

        $insurer = $this->constraints->insurer($patient);
        $minDate = $this->constraints->adjustMinDate($patient, $r->minDate);

        if ($insurer && !is_null($insurer->max_total_appointments) && Appointment::query()->count() >= (int) $insurer->max_total_appointments) {
            return collect();
        }

        $durationMin = $r->defaultFirstVisitMinutes;
        $durationMax = $r->defaultFirstVisitMinutes;

        if ($r->procedureCode && '0' !== $r->procedureCode) {
            $procedure = Procedure::query()->where('code', $r->procedureCode)->first();

            if ($procedure) {
                $durationMin = (int) $procedure->min_duration_minutes;
                $durationMax = (int) $procedure->max_duration_minutes;
            }
        }
        $duration = null !== $r->desiredDurationMinutes ? max($durationMin, min($r->desiredDurationMinutes, $durationMax)) : $durationMin;

        $doctors      = $this->doctorSelector->select($r->doctorId, $r->procedureCode, $r->specialtyCode);
        $daysToSearch = max(0, $r->daysToSearch);
        $endSearch    = $minDate->copy()->addDays($daysToSearch);
        $doctorIds    = $doctors->pluck('id')->all();
        $roomIds      = $this->helpers->buildRoomIds($r->requireRoom, $r->roomCode);

        $pre                                                                                                          = $this->preloader->preload($doctorIds, $roomIds, $patient->id, $minDate, $endSearch);
        $clinicSchedules                                                                                              = $this->helpers->clinicSchedules();
        ['pickRoom' => $pickRoom, 'insurerAllows' => $insurerAllows, 'getSchedulesByDoctor' => $getSchedulesByDoctor] = $this->helpers->buildClosures($insurer, $roomIds, $this->availability, $pre['roomBlocksByRoom'], $pre['appointmentsByRoom']);

        // Clinic-general path (only if clinic schedules exist); otherwise fall back to doctor-based search
        if ((null === $r->doctorId || 0 === $r->doctorId) && (null === $r->specialtyCode || '' === $r->specialtyCode || '0' === $r->specialtyCode) && (null === $r->procedureCode || '' === $r->procedureCode || '0' === $r->procedureCode) && $clinicSchedules->isNotEmpty()) {
            return $this->clinicFinder->find($clinicSchedules, $minDate, $endSearch, $r->defaultFirstVisitMinutes, $r->requireRoom, $r->roomCode, $r->maxSlots, $pickRoom);
        }

        $doctorReq = new DoctorSlotRequest(
            doctors: $doctors,
            minDate: $minDate,
            endSearch: $endSearch,
            procedureCode: $r->procedureCode,
            durationMin: $durationMin,
            durationMax: $durationMax,
            duration: $duration,
            maxSlots: $r->maxSlots,
            roomCode: $r->roomCode,
            requireRoom: $r->requireRoom,
            getSchedulesByDoctor: $getSchedulesByDoctor,
            insurerAllows: $insurerAllows,
            pickRoom: $pickRoom,
            doctorBlocksByDoc: $pre['doctorBlocksByDoc'],
            appointmentsByDoc: $pre['appointmentsByDoc'],
            patientAppointments: $pre['patientAppointments'],
            clinicSchedules: $clinicSchedules,
        );

        return $this->doctorFinder->find($doctorReq);
    }
}
