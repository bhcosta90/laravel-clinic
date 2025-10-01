<?php

namespace Core\Domain\Entities\Requests\Procedure;

class ProcedureUpdateRequest
{
    public function __construct(
        public string $name,
        public int $minDurationMinutes,
        public int $maxDurationMinutes,
    ) {}
}
