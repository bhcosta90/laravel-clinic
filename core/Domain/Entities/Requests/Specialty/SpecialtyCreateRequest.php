<?php

namespace Core\Domain\Entities\Requests\Specialty;

class SpecialtyCreateRequest
{
    public function __construct(
        public string $name,
        public string $code,
    ) {}
}
