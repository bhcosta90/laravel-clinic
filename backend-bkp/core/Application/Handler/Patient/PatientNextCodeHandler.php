<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Patient;

use Core\Domain\Repository\PatientRepositoryInterface;

final readonly class PatientNextCodeHandler
{
    public function __construct(
        private PatientRepositoryInterface $repository
    ) {
    }

    public function execute(): string
    {
        return $this->repository->generateCode(9);
    }
}
