<?php

declare(strict_types = 1);

namespace Core\Domain\Entities;

use Core\Domain\Entities\Requests\Room\RoomCreateRequest;
use Core\Domain\Entities\Requests\Room\RoomUpdateRequest;
use Core\Shared\Domain\BaseDomain;

final readonly class RoomEntity extends BaseDomain
{
    protected string $name;

    protected bool $isActive;

    protected readonly string $code;

    public function __construct(RoomCreateRequest $request, string | int | null $id = null)
    {
        $this->name     = $request->name;
        $this->code     = $request->code;
        $this->isActive = $request->isActive;
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

    public function update(RoomUpdateRequest $request): void
    {
        $this->name = $request->name;
        $this->validate();
    }

    public function enable(): self
    {
        $this->isActive = true;

        return $this;
    }

    public function disable(): self
    {
        $this->isActive = false;

        return $this;
    }
}
