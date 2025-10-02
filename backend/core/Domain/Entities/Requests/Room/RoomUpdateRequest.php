<?php

declare(strict_types = 1);

namespace Core\Domain\Entities\Requests\Room;

final readonly class RoomUpdateRequest
{
    public function __construct(
        public string $name,
    ) {
    }
}
