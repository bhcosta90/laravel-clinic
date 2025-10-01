<?php

declare(strict_types = 1);

namespace Core\Domain\Entities\Requests\Patient;

final class PatientCreateRequest
{
    public function __construct(
        public string $name,
        public string $code,
    ) {
    }
}
