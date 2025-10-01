<?php

namespace Core\Application\Handler\Patient;

use Core\Application\Data\PatientOutput;
use Core\Domain\Entities\PatientEntity;
use Core\Domain\Entities\Requests\Patient\PatientUpdateRequest;
use Core\Domain\Repository\PatientRepositoryInterface;
use Core\Shared\Application\Exception\NotFoundException;

class PatientUpdateHandler
{
    public function __construct(
        protected PatientRepositoryInterface $repository
    ) {}

    public function execute(
        int|string $id,
        array $data,
    ): PatientOutput {

        $entity = $this->repository->find($id);

        if ($entity === null) {
            throw new NotFoundException('Patient not found');
        }

        $req = new PatientUpdateRequest(
            name: $data['name'] ?? $entity->name,
        );

        $entity->update($req);

        /** @var PatientEntity $saved */
        $saved = $this->repository->update($entity);

        return new PatientOutput(
            id: $saved->id,
            name: $saved->name,
            code: $saved->code,
        );
    }
}
