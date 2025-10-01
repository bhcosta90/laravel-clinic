<?php

declare(strict_types = 1);

namespace Core\Domain\Repository;

use Core\Domain\Entities\Aggregate\ScheduleAggregate;
use Core\Domain\Entities\DoctorEntity;
use Core\Shared\Domain\BaseDomain;
use Core\Shared\Domain\Contracts\RepositoryInterface;

interface DoctorRepositoryInterface extends RepositoryInterface
{
    public function find(
        int | string $id,
        ?ScheduleAggregate $aggregate = null
    ): ?BaseDomain;

    public function storeSchedule(DoctorEntity $entity): ScheduleAggregate;

    public function updateSchedule(DoctorEntity $entity, ScheduleAggregate $aggregate): ?ScheduleAggregate;

    public function deleteSchedule(DoctorEntity $entity, ScheduleAggregate $aggregate): bool;

    public function findSchedule(DoctorEntity $doctor, int | string $id): ?ScheduleAggregate;
}
