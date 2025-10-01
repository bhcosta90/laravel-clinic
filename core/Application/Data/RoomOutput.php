<?php

namespace Core\Application\Data;

class RoomOutput
{
    public function __construct(
        public int|string $id,
        public string $name,
        public string $code,
        public bool $is_active,
    ) {}
}
