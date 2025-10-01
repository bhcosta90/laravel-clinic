<?php

declare(strict_types = 1);

namespace Core\Domain\Entities;

use Core\Domain\Entities\Requests\Procedure\ProcedureCreateRequest;
use Core\Domain\Entities\Requests\Procedure\ProcedureUpdateRequest;
use Core\Shared\Domain\BaseDomain;

final readonly class ProcedureEntity extends BaseDomain
{
    protected string $name;

    protected int $minDurationMinutes;

    protected int $maxDurationMinutes;

    protected readonly string $code;

    public function __construct(ProcedureCreateRequest $request, string | int | null $id = null)
    {
        $this->name               = $request->name;
        $this->code               = $request->code;
        $this->minDurationMinutes = $request->minDurationMinutes;
        $this->maxDurationMinutes = $request->maxDurationMinutes;
        $this->validate();
        parent::__construct($id);
    }

    public function validate(): void
    {
        if ($this->minDurationMinutes > $this->maxDurationMinutes) {
            $min                      = $this->minDurationMinutes;
            $this->minDurationMinutes = $this->maxDurationMinutes;
            $this->maxDurationMinutes = $min;
        }

        $this->validator()
            ->data([
                'nome'                 => $this->name,
                'code'                 => $this->code,
                'min_duration_minutes' => $this->minDurationMinutes,
                'max_duration_minutes' => $this->maxDurationMinutes,
            ])
            ->field('nome')->required()->min(3)
            ->field('code')->required()->min(6)
            ->field('min_duration_minutes')->required()->min(1)
            ->field('max_duration_minutes')->required()->min(1)
            ->validate();
    }

    public function update(ProcedureUpdateRequest $request): void
    {
        $this->name               = $request->name;
        $this->minDurationMinutes = $request->minDurationMinutes;
        $this->maxDurationMinutes = $request->maxDurationMinutes;
        $this->validate();
    }
}
