<?php

namespace Core\Application\Handler\Specialty;

use Core\Domain\Repository\SpecialtyRepositoryInterface;

class SpecialtyNextCodeHandler
{
    public function __construct(
        protected SpecialtyRepositoryInterface $repository
    ) {}

    public function execute(): string
    {
        return $this->repository->generateCode(9);
    }
}
