<?php

declare(strict_types = 1);

namespace Core\Domain\Entities\Requests\Specialty;

final class SpecialtyCreateRequest
{
    public function __construct(
        public string $name,
        public string $code,
    ) {
    }
}
