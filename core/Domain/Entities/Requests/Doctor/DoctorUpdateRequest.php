<?php

declare(strict_types = 1);

namespace Core\Domain\Entities\Requests\Doctor;

final class DoctorUpdateRequest
{
    public function __construct(
        public string $name,
    ) {
    }
}
