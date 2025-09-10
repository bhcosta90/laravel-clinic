<?php

declare(strict_types = 1);

namespace App\Services\Domain\Scheduling;

use Carbon\Carbon;
use Illuminate\Support\Collection;

final class DoctorSlotRequest
{
    public function __construct(
        public Collection $doctors,
        public Carbon $minDate,
        public Carbon $endSearch,
        public ?string $procedureCode,
        public int $durationMin,
        public int $durationMax,
        public int $duration,
        public ?int $maxSlots,
        public ?string $roomCode,
        public bool $requireRoom,
        /** @var callable */
        public $getSchedulesByDoctor,
        /** @var callable */
        public $insurerAllows,
        /** @var callable */
        public $pickRoom,
        public Collection $doctorBlocksByDoc,
        public Collection $appointmentsByDoc,
        public Collection $patientAppointments,
        public Collection $clinicSchedules,
    ) {
    }
}
