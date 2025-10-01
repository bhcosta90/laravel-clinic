<?php

namespace Core\Application\Data;

class DoctorOutput
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
}
