<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Room;

use Core\Application\Data\RoomOutput;
use Core\Domain\Entities\Requests\Room\RoomUpdateRequest;
use Core\Domain\Entities\RoomEntity;
use Core\Domain\Repository\RoomRepositoryInterface;
use Core\Shared\Application\Exception\NotFoundException;

final readonly class RoomUpdateHandler
{
    public function __construct(
        private RoomRepositoryInterface $repository
    ) {
    }

    public function execute(int | string $id, array $data): RoomOutput
    {

        /** @var RoomEntity $entity */
        $entity = $this->repository->find($id);

        if (null === $entity) {
            throw new NotFoundException('Room not found');
        }

        $req = new RoomUpdateRequest(
            name: $data['name'] ?? $entity->name,
        );

        $entity->update($req);

        when(isset($data['is_active']), fn () => $data['is_active'] ? $entity->enable() : $entity->disable());

        /** @var RoomEntity $saved */
        $saved = $this->repository->update($entity);

        return new RoomOutput(
            id: $saved->id,
            name: $saved->name,
            code: $saved->code,
            is_active: $saved->isActive,
        );
    }
}
