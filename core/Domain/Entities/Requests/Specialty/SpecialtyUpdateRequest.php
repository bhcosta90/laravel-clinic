<?php

namespace Core\Domain\Entities\Requests\Specialty;

class SpecialtyUpdateRequest
{
    public function __construct(
        public string $name,
    ) {}
}
