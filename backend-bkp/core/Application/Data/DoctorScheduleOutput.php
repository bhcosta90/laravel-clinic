<?php

declare(strict_types = 1);

namespace Core\Application\Data;

final class DoctorScheduleOutput
{
    public function __construct(
        public readonly int | string $id,
        public readonly int | string $doctor_id,
        public string $day_of_week,
        public readonly string $start_time,
        public readonly string $end_time,
        public readonly int $slot_minutes,
    ) {
        $this->day_of_week = mb_strtolower($this->day_of_week);
    }
}
