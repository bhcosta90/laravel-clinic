<?php

namespace Core\Application\Handler\Room;

use Core\Application\Data\RoomOutput;
use Core\Domain\Entities\RoomEntity;
use Core\Domain\Repository\RoomRepositoryInterface;
use Core\Shared\Application\Exception\NotFoundException;

class RoomShowHandler
{
    public function __construct(
        protected RoomRepositoryInterface $repository
    ) {}

    public function execute(
        int|string $id,
    ): RoomOutput {

        /** @var RoomEntity $entity */
        $entity = $this->repository->find($id);

        if ($entity === null) {
            throw new NotFoundException('Room not found');
        }

        return new RoomOutput(
            id: $entity->id,
            name: $entity->name,
            code: $entity->code,
            is_active: $entity->isActive,
        );
    }
}
