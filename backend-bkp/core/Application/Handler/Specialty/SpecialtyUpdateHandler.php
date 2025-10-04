<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Specialty;

use Core\Application\Data\SpecialtyOutput;
use Core\Domain\Entities\Requests\Specialty\SpecialtyUpdateRequest;
use Core\Domain\Entities\SpecialtyEntity;
use Core\Domain\Repository\SpecialtyRepositoryInterface;
use Core\Shared\Application\Exception\NotFoundException;

final readonly class SpecialtyUpdateHandler
{
    public function __construct(
        private SpecialtyRepositoryInterface $repository
    ) {
    }

    public function execute(int | string $id, array $data): SpecialtyOutput
    {

        $entity = $this->repository->find($id);

        if (null === $entity) {
            throw new NotFoundException('Specialty not found');
        }

        $req = new SpecialtyUpdateRequest(
            name: $data['name'] ?? $entity->name,
        );

        $entity->update($req);

        /** @var SpecialtyEntity $saved */
        $saved = $this->repository->update($entity);

        return new SpecialtyOutput(
            id: $saved->id,
            name: $saved->name,
            code: $saved->code,
        );
    }
}
