<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Doctor;

use Core\Application\Data\DoctorOutput;
use Core\Domain\Entities\DoctorEntity;
use Core\Domain\Entities\Requests\Doctor\DoctorCreateRequest;
use Core\Domain\Repository\DoctorRepositoryInterface;

final readonly class DoctorCreateHandler
{
    public function __construct(
        private DoctorRepositoryInterface $repository
    ) {
    }

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
