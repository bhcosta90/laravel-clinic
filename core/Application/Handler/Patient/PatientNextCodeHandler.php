<?php

namespace Core\Application\Handler\Patient;

use Core\Domain\Repository\PatientRepositoryInterface;

class PatientNextCodeHandler
{
    public function __construct(
        protected PatientRepositoryInterface $repository
    ) {}

    public function execute(): string
    {
        return $this->repository->generateCode(9);
    }
}
