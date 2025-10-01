<?php

namespace Core\Application\Data;

class DoctorScheduleOutput
{
    public function __construct(
        public int|string $id,
        public int|string $doctor_id,
        public string $day_of_week,
        public string $start_time,
        public string $end_time,
        public int $slot_minutes,
    ) {}
}
