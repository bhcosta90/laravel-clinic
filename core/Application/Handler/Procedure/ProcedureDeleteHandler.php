<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Procedure;

use Core\Domain\Repository\ProcedureRepositoryInterface;
use Core\Shared\Application\Data\DeleteOutput;
use Core\Shared\Application\Exception\NotFoundException;

final class ProcedureDeleteHandler
{
    public function __construct(
        private ProcedureRepositoryInterface $repository
    ) {
    }

    public function execute(
        int | string $id,
    ): DeleteOutput {

        $entity = $this->repository->find($id);

        if (null === $entity) {
            throw new NotFoundException('Procedure not found');
        }

        return new DeleteOutput(
            success: $this->repository->delete($entity),
            message: 'Procedure deleted successfully',
        );
    }
}
