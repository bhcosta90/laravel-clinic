<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Specialty;

use Core\Application\Data\SpecialtyOutput;
use Core\Domain\Entities\SpecialtyEntity;
use Core\Domain\Repository\SpecialtyRepositoryInterface;
use Core\Shared\Application\Exception\NotFoundException;

final readonly class SpecialtyShowHandler
{
    public function __construct(
        private SpecialtyRepositoryInterface $repository
    ) {
    }

    public function execute(
        int | string $id,
    ): SpecialtyOutput {

        /** @var SpecialtyEntity $entity */
        $entity = $this->repository->find($id);

        if (null === $entity) {
            throw new NotFoundException('Specialty not found');
        }

        return new SpecialtyOutput(
            id: $entity->id,
            name: $entity->name,
            code: $entity->code,
        );
    }
}
