<?php

namespace Core\Domain\Repository;

use Core\Shared\Domain\Contracts\RepositoryInterface;

interface SpecialtyRepositoryInterface extends RepositoryInterface
{
    public function generateCode(int $min): string;
}
