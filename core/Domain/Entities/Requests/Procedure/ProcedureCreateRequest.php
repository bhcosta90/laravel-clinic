<?php

namespace Core\Domain\Entities\Requests\Procedure;

class ProcedureCreateRequest
{
    public function __construct(
        public string $name,
        public string $code,
        public int $minDurationMinutes,
        public int $maxDurationMinutes,
    ) {}
}
