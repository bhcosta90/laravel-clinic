<?php

declare(strict_types = 1);

namespace Core\Domain\Entities\Requests\Specialty;

final readonly class SpecialtyUpdateRequest
{
    public function __construct(
        public string $name,
    ) {
    }
}
