<?php

namespace Core\Domain\Entities\Requests\Patient;

class PatientUpdateRequest
{
    public function __construct(
        public string $name,
    ) {}
}
