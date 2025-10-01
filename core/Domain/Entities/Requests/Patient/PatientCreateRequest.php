<?php

namespace Core\Domain\Entities\Requests\Patient;

class PatientCreateRequest
{
    public function __construct(
        public string $name,
        public string $code,
    ) {}
}
