<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Doctor\Schedule;

use Core\Application\Data\DoctorScheduleOutput;
use Core\Application\Handler\Doctor\Schedule\Data\DoctorScheduleUpdateInput;
use Core\Domain\Aggregate\ScheduleAggregate;
use Core\Domain\Entities\DoctorEntity;
use Core\Domain\Repository\DoctorRepositoryInterface;
use Core\Shared\Application\Exception\NotFoundException;

final readonly class DoctorScheduleUpdateHandler
{
    public function __construct(
        private DoctorRepositoryInterface $repository,
    ) {
    }

    public function execute(DoctorScheduleUpdateInput $input): DoctorScheduleOutput
    {
        $id          = $input->id;
        $doctorId    = $input->doctorId;
        $dayOfWeek   = $input->dayOfWeek;
        $startTime   = $input->startTime;
        $endTime     = $input->endTime;
        $slotMinutes = $input->slotMinutes;

        $aggregate = new ScheduleAggregate(id: $id);

        /** @var DoctorEntity $doctor */
        $doctor = $this->repository->find($doctorId, $aggregate);

        $schedule = $this->repository->findSchedule($doctor, $id);

        if (null === $schedule) {
            throw new NotFoundException('Schedule not found');
        }

        $dayOfWeek   = $dayOfWeek ?? $schedule->dayOfWeek;
        $startTime   = $startTime ?? $schedule->startTime;
        $endTime     = $endTime ?? $schedule->endTime;
        $slotMinutes = $slotMinutes ?? $schedule->slotMinutes;

        $aggregate = new ScheduleAggregate($dayOfWeek, $startTime, $endTime, $slotMinutes, $schedule->id);

        $doctor->addSchedule($aggregate);
        $entity = $this->repository->updateSchedule($doctor, $aggregate);

        return new DoctorScheduleOutput(
            id: $schedule->id,
            doctor_id: $doctor->id,
            day_of_week: $entity->dayOfWeek->name,
            start_time: $entity->startTime,
            end_time: $entity->endTime,
            slot_minutes: $entity->slotMinutes,
        );
    }
}
