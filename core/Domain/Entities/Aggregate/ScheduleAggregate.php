<?php

namespace Core\Domain\Entities\Aggregate;

use Core\Domain\Enum\DayEnum;

class ScheduleAggregate
{
    public function __construct(
        public ?DayEnum $dayOfWeek = null,
        public ?string $startTime = null,
        public ?string $endTime = null,
        public ?int $slotMinutes = null,
        public ?int $id = null,
    ) {}
}
