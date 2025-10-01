<?php

namespace Core\Application\Handler\Patient;

use Core\Application\Data\PatientOutput;
use Core\Domain\Entities\PatientEntity;
use Core\Domain\Repository\PatientRepositoryInterface;
use Core\Shared\Application\Exception\NotFoundException;

class PatientShowHandler
{
    public function __construct(
        protected PatientRepositoryInterface $repository
    ) {}

    public function execute(
        int|string $id,
    ): PatientOutput {

        /** @var PatientEntity $entity */
        $entity = $this->repository->find($id);

        if ($entity === null) {
            throw new NotFoundException('Patient not found');
        }

        return new PatientOutput(
            id: $entity->id,
            name: $entity->name,
            code: $entity->code,
        );
    }
}
