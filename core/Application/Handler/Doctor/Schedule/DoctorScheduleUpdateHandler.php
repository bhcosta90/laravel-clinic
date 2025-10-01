<?php

namespace Core\Application\Handler\Doctor\Schedule;

use Core\Application\Data\DoctorScheduleOutput;
use Core\Domain\Entities\Aggregate\ScheduleAggregate;
use Core\Domain\Entities\DoctorEntity;
use Core\Domain\Repository\DoctorRepositoryInterface;
use Core\Domain\Support\DaySupport;
use Core\Shared\Application\Exception\NotFoundException;

class DoctorScheduleUpdateHandler
{
    public function __construct(
        protected DoctorRepositoryInterface $repository,
        protected DaySupport $dayWeekSupport,
    ) {}

    public function execute(
        int|string $id,
        int|string $doctorId,
        null|int|string $dayOfWeek,
        ?string $startTime,
        ?string $endTime,
        ?int $slotMinutes,
    ): DoctorScheduleOutput {
        if (is_string($dayOfWeek)) {
            $dayOfWeek = $this->dayWeekSupport->byInt($dayOfWeek);
        }

        $aggregate = new ScheduleAggregate(id: $id);

        /** @var DoctorEntity $doctor */
        $doctor = $this->repository->find($doctorId, $aggregate);

        $schedule = $this->repository->findSchedule($doctor, $id);

        if ($schedule === null) {
            throw new NotFoundException('Schedule not found');
        }

        $dayOfWeek = $dayOfWeek ?? $schedule->dayOfWeek;
        $startTime = $startTime ?? $schedule->startTime;
        $endTime = $endTime ?? $schedule->endTime;
        $slotMinutes = $slotMinutes ?? $schedule->slotMinutes;

        $aggregate = new ScheduleAggregate($dayOfWeek, $startTime, $endTime, $slotMinutes, $schedule->id);

        $doctor->addSchedule($aggregate);
        $entity = $this->repository->updateSchedule($doctor, $aggregate);

        return new DoctorScheduleOutput(
            id: $schedule->id,
            doctor_id: $doctor->id,
            day_of_week: $this->dayWeekSupport->byString($entity->dayOfWeek),
            start_time: $entity->startTime,
            end_time: $entity->endTime,
            slot_minutes: $entity->slotMinutes,
        );
    }
}
