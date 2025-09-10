<?php

declare(strict_types = 1);

namespace App\Services\Domain\Scheduling;

use Carbon\Carbon;

final readonly class SchedulingRequest
{
    public function __construct(
        public string $patientCode,
        public ?int $doctorId,
        public ?string $procedureCode,
        public Carbon $minDate,
        public int $daysToSearch,
        public int $defaultFirstVisitMinutes,
        public ?int $desiredDurationMinutes,
        public ?string $specialtyCode,
        public ?int $maxSlots,
        public ?string $roomCode,
        public bool $requireRoom,
    ) {
    }
}
