<?php

declare(strict_types = 1);

namespace Core\Domain\Entities;

use Core\Domain\Entities\Requests\Patient\PatientCreateRequest;
use Core\Domain\Entities\Requests\Patient\PatientUpdateRequest;
use Core\Shared\Domain\BaseDomain;

final class PatientEntity extends BaseDomain
{
    protected string $name;

    protected readonly string $code;

    public function __construct(PatientCreateRequest $request, string | int | null $id = null)
    {
        $this->name = $request->name;
        $this->code = $request->code;
        $this->validate();
        parent::__construct($id);
    }

    public function validate(): void
    {
        $this->validator()
            ->data([
                'nome' => $this->name,
                'code' => $this->code,
            ])
            ->field('nome')->required()->min(3)
            ->field('code')->required()->min(6)
            ->validate();
    }

    public function update(PatientUpdateRequest $request): void
    {
        $this->name = $request->name;
        $this->validate();
    }
}
