<?php

namespace Core\Application\Handler\Doctor\Schedule\Data;

use Core\Domain\Enum\DayEnum;

class DoctorScheduleCreateInput
{
    public function __construct(
        public int|string $doctorId,
        public DayEnum $dayOfWeek,
        public string $startTime,
        public string $endTime,
        public int $slotMinutes,
    ) {}
}
