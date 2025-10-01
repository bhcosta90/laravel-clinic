<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Procedure;

use Core\Domain\Repository\ProcedureRepositoryInterface;

final class ProcedureNextCodeHandler
{
    public function __construct(
        private ProcedureRepositoryInterface $repository
    ) {
    }

    public function execute(): string
    {
        return $this->repository->generateCode(9);
    }
}
