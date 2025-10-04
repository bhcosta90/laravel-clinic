<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Doctor\Schedule;

use Core\Application\Data\DoctorScheduleOutput;
use Core\Application\Handler\Doctor\Schedule\Data\DoctorScheduleCreateInput;
use Core\Domain\Aggregate\ScheduleAggregate;
use Core\Domain\Entities\DoctorEntity;
use Core\Domain\Repository\DoctorRepositoryInterface;
use Core\Shared\Application\Exception\NotFoundException;

final readonly class DoctorScheduleCreateHandler
{
    public function __construct(
        private DoctorRepositoryInterface $repository,
    ) {
    }

    public function execute(DoctorScheduleCreateInput $input): DoctorScheduleOutput
    {
        $doctorId    = $input->doctorId;
        $dayOfWeek   = $input->dayOfWeek;
        $startTime   = $input->startTime;
        $endTime     = $input->endTime;
        $slotMinutes = $input->slotMinutes;

        $aggregate = new ScheduleAggregate($dayOfWeek, $startTime, $endTime, $slotMinutes);

        /** @var DoctorEntity $doctor */
        $doctor = $this->repository->find($doctorId, $aggregate);

        if (null === $doctor) {
            throw new NotFoundException('Doctor not found');
        }

        $doctor->addSchedule($aggregate);

        $schedule = $this->repository->storeSchedule($doctor);

        return new DoctorScheduleOutput(
            id: $schedule->id,
            doctor_id: $doctor->id,
            day_of_week: $dayOfWeek->name,
            start_time: $schedule->startTime,
            end_time: $schedule->endTime,
            slot_minutes: $schedule->slotMinutes,
        );
    }
}
