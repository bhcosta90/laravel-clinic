<?php

declare(strict_types = 1);

namespace Core\Application\Data;

final readonly class DoctorOutput
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
