<?php

declare(strict_types = 1);

namespace Core\Application\Handler\Room;

use Core\Application\Data\RoomOutput;
use Core\Domain\Entities\Requests\Room\RoomCreateRequest;
use Core\Domain\Entities\RoomEntity;
use Core\Domain\Repository\RoomRepositoryInterface;

final readonly class RoomCreateHandler
{
    public function __construct(
        private RoomRepositoryInterface $repository
    ) {
    }

    public function execute(?string $code, string $name, ?bool $isActive): RoomOutput
    {

        if (null === $code) {
            $code = $this->repository->generateCode(6);
        }

        $req = new RoomCreateRequest(
            name: $name,
            code: $code,
            isActive: $isActive,
        );

        $entity = new RoomEntity($req);

        /** @var RoomEntity $saved */
        $saved = $this->repository->store($entity);

        return new RoomOutput(
            id: $saved->id,
            name: $saved->name,
            code: $saved->code,
            is_active: $saved->isActive,
        );
    }
}
