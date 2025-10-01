<?php

namespace Core\Application\Data;

class PatientOutput
{
    public function __construct(
        public int|string $id,
        public string $name,
        public string $code,
    ) {}
}
