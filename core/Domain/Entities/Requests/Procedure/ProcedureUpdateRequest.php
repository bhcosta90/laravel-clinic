<?php

declare(strict_types = 1);

namespace Core\Domain\Entities\Requests\Procedure;

final class ProcedureUpdateRequest
{
    public function __construct(
        public string $name,
        public int $minDurationMinutes,
        public int $maxDurationMinutes,
    ) {
    }
}
