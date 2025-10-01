<?php

declare(strict_types = 1);

namespace Core\Domain\Entities;

use Core\Domain\Entities\Requests\Specialty\SpecialtyCreateRequest;
use Core\Domain\Entities\Requests\Specialty\SpecialtyUpdateRequest;
use Core\Shared\Domain\BaseDomain;

final readonly class SpecialtyEntity extends BaseDomain
{
    protected string $name;

    protected readonly string $code;

    public function __construct(SpecialtyCreateRequest $request, string | int | null $id = null)
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

    public function update(SpecialtyUpdateRequest $request): void
    {
        $this->name = $request->name;
        $this->validate();
    }
}
