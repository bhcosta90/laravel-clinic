<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Room;

use Core\Domain\Repository\RoomRepositoryInterface;
use Core\Shared\Application\Data\DeleteOutput;
use Core\Shared\Application\Exception\NotFoundException;

final class RoomDeleteHandler
{
    public function __construct(
        private RoomRepositoryInterface $repository
    ) {
    }

    public function execute(
        int | string $id,
    ): DeleteOutput {

        $entity = $this->repository->find($id);

        if (null === $entity) {
            throw new NotFoundException('Room not found');
        }

        return new DeleteOutput(
            success: $this->repository->delete($entity),
            message: 'Room deleted successfully',
        );
    }
}
