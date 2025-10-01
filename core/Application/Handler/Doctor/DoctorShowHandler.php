<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Doctor;

use Core\Application\Data\DoctorOutput;
use Core\Domain\Entities\DoctorEntity;
use Core\Domain\Repository\DoctorRepositoryInterface;
use Core\Shared\Application\Exception\NotFoundException;

final class DoctorShowHandler
{
    public function __construct(
        private DoctorRepositoryInterface $repository
    ) {
    }

    public function execute(
        int | string $id,
    ): DoctorOutput {

        /** @var DoctorEntity $entity */
        $entity = $this->repository->find($id);

        if (null === $entity) {
            throw new NotFoundException('Doctor not found');
        }

        return new DoctorOutput(
            id: $entity->id,
            name: $entity->name,
        );
    }
}
