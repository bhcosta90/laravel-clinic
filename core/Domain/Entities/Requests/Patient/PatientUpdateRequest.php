<?php

declare(strict_types = 1);

namespace Core\Domain\Entities\Requests\Patient;

final class PatientUpdateRequest
{
    public function __construct(
        public string $name,
    ) {
    }
}
