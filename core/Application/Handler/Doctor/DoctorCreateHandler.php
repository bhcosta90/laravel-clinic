<?php

namespace Core\Application\Handler\Doctor;

use Core\Application\Data\DoctorOutput;
use Core\Domain\Entities\DoctorEntity;
use Core\Domain\Entities\Requests\Doctor\DoctorCreateRequest;
use Core\Domain\Repository\DoctorRepositoryInterface;

class DoctorCreateHandler
{
    public function __construct(
        protected DoctorRepositoryInterface $repository
    ) {}

    public function execute(
        string $name,
    ): DoctorOutput {

        $req = new DoctorCreateRequest(
            name: $name,
        );

        $entity = new DoctorEntity($req);

        /** @var DoctorEntity $saved */
        $saved = $this->repository->store($entity);

        return new DoctorOutput(
            id: $saved->id,
            name: $saved->name,
        );
    }
}
