<?php

namespace Core\Domain\Entities\Requests\Room;

class RoomCreateRequest
{
    public function __construct(
        public string $name,
        public string $code,
        public bool $isActive,
    ) {}
}
