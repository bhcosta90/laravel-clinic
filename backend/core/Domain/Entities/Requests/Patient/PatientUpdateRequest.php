<?php

declare(strict_types = 1);

namespace Core\Domain\Entities\Requests\Patient;

final readonly class PatientUpdateRequest
{
    public function __construct(
        public string $name,
    ) {
    }
}
