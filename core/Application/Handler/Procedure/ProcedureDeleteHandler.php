<?php

namespace Core\Application\Handler\Procedure;

use Core\Domain\Repository\ProcedureRepositoryInterface;
use Core\Shared\Application\Data\DeleteOutput;
use Core\Shared\Application\Exception\NotFoundException;

class ProcedureDeleteHandler
{
    public function __construct(
        protected ProcedureRepositoryInterface $repository
    ) {}

    public function execute(
        int|string $id,
    ): DeleteOutput {

        $entity = $this->repository->find($id);

        if ($entity === null) {
            throw new NotFoundException('Procedure not found');
        }

        return new DeleteOutput(
            success: $this->repository->delete($entity),
            message: 'Procedure deleted successfully',
        );
    }
}
