<?php

namespace Core\Application\Handler\Doctor\Schedule;

use Core\Domain\Entities\Aggregate\ScheduleAggregate;
use Core\Domain\Entities\DoctorEntity;
use Core\Domain\Repository\DoctorRepositoryInterface;
use Core\Shared\Application\Data\DeleteOutput;
use Core\Shared\Application\Exception\NotFoundException;

class DoctorScheduleDeleteHandler
{
    public function __construct(
        protected DoctorRepositoryInterface $repository,
    ) {}

    public function execute(
        int|string $id,
        int|string $doctorId,
    ): DeleteOutput {
        /** @var DoctorEntity $doctor */
        $doctor = $this->repository->find($doctorId);

        /** @var ScheduleAggregate $schedule */
        $schedule = $this->repository->findSchedule($doctor, $id);

        if ($schedule === null) {
            throw new NotFoundException('Schedule not found');
        }

        $entity = $this->repository->findSchedule($doctor, $id);

        if ($entity === null) {
            throw new NotFoundException('Doctor not found');
        }

        return new DeleteOutput(
            success: $this->repository->deleteSchedule($doctor, $entity),
            message: 'Schedule deleted successfully',
        );
    }
}
