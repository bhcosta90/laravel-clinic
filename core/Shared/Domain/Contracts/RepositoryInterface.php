<?php

namespace Core\Shared\Domain\Contracts;

use Core\Shared\Domain\BaseDomain;

interface RepositoryInterface
{
    public function find(int|string $id): ?BaseDomain;

    public function delete(BaseDomain $domain): bool;

    public function store(BaseDomain $domain): BaseDomain;

    public function update(BaseDomain $domain): BaseDomain;
}
