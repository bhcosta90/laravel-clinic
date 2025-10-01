<?php

declare(strict_types = 1);

namespace Core\Domain\Entities\Requests\Doctor;

final class DoctorCreateRequest
{
    public function __construct(
        public string $name,
    ) {
    }
}
