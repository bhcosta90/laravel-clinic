<?php

declare(strict_types = 1);

namespace Core\Application\Data;

final readonly class ProcedureOutput
{
    public function __construct(
        public int | string $id,
        public string $name,
        public string $code,
        public int $min_duration_minutes,
        public int $max_duration_minutes,
    ) {
    }
}
