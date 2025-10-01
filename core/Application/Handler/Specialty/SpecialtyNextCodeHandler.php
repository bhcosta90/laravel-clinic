<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Specialty;

use Core\Domain\Repository\SpecialtyRepositoryInterface;

final class SpecialtyNextCodeHandler
{
    public function __construct(
        private SpecialtyRepositoryInterface $repository
    ) {
    }

    public function execute(): string
    {
        return $this->repository->generateCode(9);
    }
}
