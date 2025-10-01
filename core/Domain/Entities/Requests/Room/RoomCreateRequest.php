<?php

declare(strict_types = 1);

namespace Core\Domain\Entities\Requests\Room;

final class RoomCreateRequest
{
    public function __construct(
        public string $name,
        public string $code,
        public bool $isActive,
    ) {
    }
}
