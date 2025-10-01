<?php

namespace Core\Application\Handler\Doctor;

use Core\Application\Data\DoctorOutput;
use Core\Domain\Entities\DoctorEntity;
use Core\Domain\Entities\Requests\Doctor\DoctorUpdateRequest;
use Core\Domain\Repository\DoctorRepositoryInterface;
use Core\Shared\Application\Exception\NotFoundException;

class DoctorUpdateHandler
{
    public function __construct(
        protected DoctorRepositoryInterface $repository
    ) {}

    public function execute(
        int|string $id,
        array $data,
    ): DoctorOutput {

        $entity = $this->repository->find($id);

        if ($entity === null) {
            throw new NotFoundException('Doctor not found');
        }

        $req = new DoctorUpdateRequest(
            name: $data['name'] ?? $entity->name,
        );

        $entity->update($req);

        /** @var DoctorEntity $saved */
        $saved = $this->repository->update($entity);

        return new DoctorOutput(
            id: $saved->id,
            name: $saved->name,
        );
    }
}
