<?php

namespace Core\Application\Handler\Procedure;

use Core\Domain\Repository\ProcedureRepositoryInterface;

class ProcedureNextCodeHandler
{
    public function __construct(
        protected ProcedureRepositoryInterface $repository
    ) {}

    public function execute(): string
    {
        return $this->repository->generateCode(9);
    }
}
