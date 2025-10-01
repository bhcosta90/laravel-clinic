<?php

namespace Core\Application\Data;

class SpecialtyOutput
{
    public function __construct(
        public int|string $id,
        public string $name,
        public string $code,
    ) {}
}
