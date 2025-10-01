<?php

namespace Core\Application\Handler\Procedure;

use Core\Application\Data\ProcedureOutput;
use Core\Domain\Entities\ProcedureEntity;
use Core\Domain\Entities\Requests\Procedure\ProcedureCreateRequest;
use Core\Domain\Repository\ProcedureRepositoryInterface;

class ProcedureCreateHandler
{
    public function __construct(
        protected ProcedureRepositoryInterface $repository
    ) {}

    public function execute(
        ?string $code,
        string $name,
        int $minDurationMinutes,
        int $maxDurationMinutes,
    ): ProcedureOutput {

        if ($code === null) {
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
