<?php

namespace Core\Application\Handler\Doctor\Schedule;

use Core\Application\Data\DoctorScheduleOutput;
use Core\Domain\Entities\Aggregate\ScheduleAggregate;
use Core\Domain\Entities\DoctorEntity;
use Core\Domain\Repository\DoctorRepositoryInterface;
use Core\Domain\Support\DaySupport;
use Core\Shared\Application\Exception\NotFoundException;

class DoctorScheduleCreateHandler
{
    public function __construct(
        protected DoctorRepositoryInterface $repository,
        protected DaySupport $dayWeekSupport,
    ) {}

    public function execute(
        int|string $doctorId,
        int|string $dayOfWeek,
        string $startTime,
        string $endTime,
        int $slotMinutes,
    ): DoctorScheduleOutput {
        if (is_string($dayOfWeek)) {
            $dayOfWeek = $this->dayWeekSupport->byInt($dayOfWeek);
        }

        $aggregate = new ScheduleAggregate($dayOfWeek, $startTime, $endTime, $slotMinutes);

        /** @var DoctorEntity $doctor */
        $doctor = $this->repository->find($doctorId, $aggregate);

        if ($doctor === null) {
            throw new NotFoundException('Doctor not found');
        }

        $doctor->addSchedule($aggregate);

        $schedule = $this->repository->storeSchedule($doctor);

        return new DoctorScheduleOutput(
            id: $schedule->id,
            doctor_id: $doctor->id,
            day_of_week: $this->dayWeekSupport->byString($schedule->dayOfWeek),
            start_time: $schedule->startTime,
            end_time: $schedule->endTime,
            slot_minutes: $schedule->slotMinutes,
        );
    }
}
