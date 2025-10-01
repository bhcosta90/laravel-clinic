<?php

declare(strict_types = 1);

namespace Core\Application\Data;

final class RoomOutput
{
    public function __construct(
        public int | string $id,
        public string $name,
        public string $code,
        public bool $is_active,
    ) {
    }
}
