<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Room;

use Core\Domain\Repository\RoomRepositoryInterface;

final class RoomNextCodeHandler
{
    public function __construct(
        private RoomRepositoryInterface $repository
    ) {
    }

    public function execute(): string
    {
        return $this->repository->generateCode(9);
    }
}
