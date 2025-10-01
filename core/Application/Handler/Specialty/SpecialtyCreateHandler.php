<?php

namespace Core\Application\Handler\Specialty;

use Core\Application\Data\SpecialtyOutput;
use Core\Domain\Entities\Requests\Specialty\SpecialtyCreateRequest;
use Core\Domain\Entities\SpecialtyEntity;
use Core\Domain\Repository\SpecialtyRepositoryInterface;

class SpecialtyCreateHandler
{
    public function __construct(
        protected SpecialtyRepositoryInterface $repository
    ) {}

    public function execute(
        ?string $code,
        string $name,
    ): SpecialtyOutput {

        if ($code === null) {
            $code = $this->repository->generateCode(6);
        }

        $req = new SpecialtyCreateRequest(
            name: $name,
            code: $code,
        );

        $entity = new SpecialtyEntity($req);

        /** @var SpecialtyEntity $saved */
        $saved = $this->repository->store($entity);

        return new SpecialtyOutput(
            id: $saved->id,
            name: $saved->name,
            code: $saved->code,
        );
    }
}
