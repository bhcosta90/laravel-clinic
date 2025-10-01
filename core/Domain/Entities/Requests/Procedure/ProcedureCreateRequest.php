<?php

declare(strict_types = 1);

namespace Core\Domain\Entities\Requests\Procedure;

final class ProcedureCreateRequest
{
    public function __construct(
        public string $name,
        public string $code,
        public int $minDurationMinutes,
        public int $maxDurationMinutes,
    ) {
    }
}
