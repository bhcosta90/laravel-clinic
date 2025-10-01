<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Procedure;

use Core\Application\Data\ProcedureOutput;
use Core\Domain\Entities\ProcedureEntity;
use Core\Domain\Entities\Requests\Procedure\ProcedureUpdateRequest;
use Core\Domain\Repository\ProcedureRepositoryInterface;
use Core\Shared\Application\Exception\NotFoundException;

final class ProcedureUpdateHandler
{
    public function __construct(
        private ProcedureRepositoryInterface $repository
    ) {
    }

    public function execute(
        int | string $id,
        array $data,
    ): ProcedureOutput {

        $entity = $this->repository->find($id);

        if (null === $entity) {
            throw new NotFoundException('Procedure not found');
        }

        $req = new ProcedureUpdateRequest(
            name: $data['name'] ?? $entity->name,
            minDurationMinutes: $data['min_duration_minutes'] ?? $entity->minDurationMinutes,
            maxDurationMinutes: $data['max_duration_minutes'] ?? $entity->maxDurationMinutes,
        );

        $entity->update($req);

        /** @var ProcedureEntity $saved */
        $saved = $this->repository->update($entity);

        return new ProcedureOutput(
            id: $saved->id,
            name: $saved->name,
            code: $saved->code,
            min_duration_minutes: $saved->minDurationMinutes,
            max_duration_minutes: $saved->maxDurationMinutes,
        );
    }
}
