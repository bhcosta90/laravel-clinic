<?php

declare(strict_types = 1);

namespace Core\Domain\Entities\Requests\Doctor;

final readonly class DoctorUpdateRequest
{
    public function __construct(
        public string $name,
    ) {
    }
}
