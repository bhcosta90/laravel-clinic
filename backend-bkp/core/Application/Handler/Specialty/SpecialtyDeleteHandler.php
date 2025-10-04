<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Specialty;

use Core\Domain\Repository\SpecialtyRepositoryInterface;
use Core\Shared\Application\Data\DeleteOutput;
use Core\Shared\Application\Exception\NotFoundException;

final readonly class SpecialtyDeleteHandler
{
    public function __construct(
        private SpecialtyRepositoryInterface $repository
    ) {
    }

    public function execute(
        int | string $id,
    ): DeleteOutput {

        $entity = $this->repository->find($id);

        if (null === $entity) {
            throw new NotFoundException('Specialty not found');
        }

        return new DeleteOutput(
            success: $this->repository->delete($entity),
            message: 'Specialty deleted successfully',
        );
    }
}
