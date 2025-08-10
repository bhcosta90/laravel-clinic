<?php

declare(strict_types=1);

namespace App\Traits\Models;

trait NodeTrait
{
    use \Kalnoy\Nestedset\NodeTrait;

    public function getLftName(): string
    {
        return 'nested_left';
    }

    public function getRgtName(): string
    {
        return 'nested_right';
    }

    public function getParentIdName(): string
    {
        return 'nested_parent';
    }

    public function setParentAttribute($value): void
    {
        $this->setParentIdAttribute($value);
    }
}
