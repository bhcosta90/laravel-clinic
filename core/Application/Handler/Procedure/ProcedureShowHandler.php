<?php

namespace Core\Application\Handler\Procedure;

use Core\Application\Data\ProcedureOutput;
use Core\Domain\Entities\ProcedureEntity;
use Core\Domain\Repository\ProcedureRepositoryInterface;
use Core\Shared\Application\Exception\NotFoundException;

class ProcedureShowHandler
{
    public function __construct(
        protected ProcedureRepositoryInterface $repository
    ) {}

    public function execute(
        int|string $id,
    ): ProcedureOutput {

        /** @var ProcedureEntity $entity */
        $entity = $this->repository->find($id);

        if ($entity === null) {
            throw new NotFoundException('Procedure not found');
        }

        return new ProcedureOutput(
            id: $entity->id,
            name: $entity->name,
            code: $entity->code,
            min_duration_minutes: $entity->minDurationMinutes,
            max_duration_minutes: $entity->maxDurationMinutes,
        );
    }
}
