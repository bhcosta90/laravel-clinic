<?php

declare(strict_types = 1);

namespace Core\Domain\Aggregate;

use Core\Domain\Enum\DayEnum;

final readonly class ScheduleAggregate
{
    public function __construct(
        public ?DayEnum $dayOfWeek = null,
        public ?string $startTime = null,
        public ?string $endTime = null,
        public ?int $slotMinutes = null,
        public ?int $id = null,
    ) {
    }
}
