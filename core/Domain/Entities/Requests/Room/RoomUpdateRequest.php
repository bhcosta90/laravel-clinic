<?php

namespace Core\Domain\Entities\Requests\Room;

class RoomUpdateRequest
{
    public function __construct(
        public string $name,
    ) {}
}
