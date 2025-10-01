<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Doctor\Schedule;

use Core\Domain\Entities\Aggregate\ScheduleAggregate;
use Core\Domain\Entities\DoctorEntity;
use Core\Domain\Repository\DoctorRepositoryInterface;
use Core\Shared\Application\Data\DeleteOutput;
use Core\Shared\Application\Exception\NotFoundException;

final readonly class DoctorScheduleDeleteHandler
{
    public function __construct(
        private DoctorRepositoryInterface $repository,
    ) {
    }

    public function execute(
        int | string $id,
        int | string $doctorId,
    ): DeleteOutput {
        /** @var DoctorEntity $doctor */
        $doctor = $this->repository->find($doctorId, new ScheduleAggregate(id: $id));

        /** @var ScheduleAggregate $schedule */
        $schedule = $this->repository->findSchedule($doctor, $id);

        if (null === $schedule) {
            throw new NotFoundException('Schedule not found');
        }

        $entity = $this->repository->findSchedule($doctor, $id);

        if (null === $entity) {
            throw new NotFoundException('Doctor not found');
        }

        return new DeleteOutput(
            success: $this->repository->deleteSchedule($doctor, $entity),
            message: 'Schedule deleted successfully',
        );
    }
}
