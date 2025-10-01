<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Patient;

use Core\Application\Data\PatientOutput;
use Core\Domain\Entities\PatientEntity;
use Core\Domain\Repository\PatientRepositoryInterface;
use Core\Shared\Application\Exception\NotFoundException;

final class PatientShowHandler
{
    public function __construct(
        private PatientRepositoryInterface $repository
    ) {
    }

    public function execute(
        int | string $id,
    ): PatientOutput {

        /** @var PatientEntity $entity */
        $entity = $this->repository->find($id);

        if (null === $entity) {
            throw new NotFoundException('Patient not found');
        }

        return new PatientOutput(
            id: $entity->id,
            name: $entity->name,
            code: $entity->code,
        );
    }
}
