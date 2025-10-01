<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Procedure;

use Core\Application\Data\ProcedureOutput;
use Core\Domain\Entities\ProcedureEntity;
use Core\Domain\Entities\Requests\Procedure\ProcedureCreateRequest;
use Core\Domain\Repository\ProcedureRepositoryInterface;

final readonly class ProcedureCreateHandler
{
    public function __construct(
        private ProcedureRepositoryInterface $repository
    ) {
    }

    public function execute(
        ?string $code,
        string $name,
        int $minDurationMinutes,
        int $maxDurationMinutes,
    ): ProcedureOutput {

        if (null === $code) {
            $code = $this->repository->generateCode(6);
        }

        $req = new ProcedureCreateRequest(
            name: $name,
            code: $code,
            minDurationMinutes: $minDurationMinutes,
            maxDurationMinutes: $maxDurationMinutes
        );

        $entity = new ProcedureEntity($req);

        /** @var ProcedureEntity $saved */
        $saved = $this->repository->store($entity);

        return new ProcedureOutput(
            id: $saved->id,
            name: $saved->name,
            code: $saved->code,
            min_duration_minutes: $saved->minDurationMinutes,
            max_duration_minutes: $saved->maxDurationMinutes,
        );
    }
}
