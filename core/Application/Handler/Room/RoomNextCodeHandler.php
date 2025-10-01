<?php

namespace Core\Application\Handler\Room;

use Core\Domain\Repository\RoomRepositoryInterface;

class RoomNextCodeHandler
{
    public function __construct(
        protected RoomRepositoryInterface $repository
    ) {}

    public function execute(): string
    {
        return $this->repository->generateCode(9);
    }
}
