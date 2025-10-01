<?php

namespace Core\Domain\Entities\Requests\Doctor;

class DoctorUpdateRequest
{
    public function __construct(
        public string $name,
    ) {}
}
