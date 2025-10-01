<?php

namespace Core\Domain\Entities\Requests\Doctor;

class DoctorCreateRequest
{
    public function __construct(
        public string $name,
    ) {}
}
