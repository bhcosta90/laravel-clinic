<?php

namespace Core\Domain\Entities\Aggregate;

class ScheduleAggregate
{
    public function __construct(
        public ?int $dayOfWeek = null,
        public ?string $startTime = null,
        public ?string $endTime = null,
        public ?int $slotMinutes = null,
        public ?int $id = null,
    ) {}
}
