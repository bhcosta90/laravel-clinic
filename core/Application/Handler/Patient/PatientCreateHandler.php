<?php

namespace Core\Application\Handler\Patient;

use Core\Application\Data\PatientOutput;
use Core\Domain\Entities\PatientEntity;
use Core\Domain\Entities\Requests\Patient\PatientCreateRequest;
use Core\Domain\Repository\PatientRepositoryInterface;

class PatientCreateHandler
{
    public function __construct(
        protected PatientRepositoryInterface $repository
    ) {}

    public function execute(
        ?string $code,
        string $name,
    ): PatientOutput {

        if ($code === null) {
            $code = $this->repository->generateCode(6);
        }

        $req = new PatientCreateRequest(
            name: $name,
            code: $code,
        );

        $entity = new PatientEntity($req);

        /** @var PatientEntity $saved */
        $saved = $this->repository->store($entity);

        return new PatientOutput(
            id: $saved->id,
            name: $saved->name,
            code: $saved->code,
        );
    }
}
