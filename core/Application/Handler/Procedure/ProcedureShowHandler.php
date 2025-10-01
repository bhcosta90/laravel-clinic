<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Procedure;

use Core\Application\Data\ProcedureOutput;
use Core\Domain\Entities\ProcedureEntity;
use Core\Domain\Repository\ProcedureRepositoryInterface;
use Core\Shared\Application\Exception\NotFoundException;

final readonly class ProcedureShowHandler
{
    public function __construct(
        private ProcedureRepositoryInterface $repository
    ) {
    }

    public function execute(
        int | string $id,
    ): ProcedureOutput {

        /** @var ProcedureEntity $entity */
        $entity = $this->repository->find($id);

        if (null === $entity) {
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
