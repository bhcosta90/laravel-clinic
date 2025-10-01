<?php

namespace Core\Application\Handler\Room;

use Core\Application\Data\RoomOutput;
use Core\Domain\Entities\Requests\Room\RoomCreateRequest;
use Core\Domain\Entities\RoomEntity;
use Core\Domain\Repository\RoomRepositoryInterface;

class RoomCreateHandler
{
    public function __construct(
        protected RoomRepositoryInterface $repository
    ) {}

    public function execute(
        ?string $code,
        string $name,
        ?bool $isActive,
    ): RoomOutput {

        if ($code === null) {
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
