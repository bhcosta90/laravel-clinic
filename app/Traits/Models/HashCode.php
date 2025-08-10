<?php

declare(strict_types=1);

namespace App\Traits\Models;

use Vinkla\Hashids\Facades\Hashids;

trait HashCode
{
    public function getHashCodeAttribute(): string
    {
        return Hashids::connection('code')->encode($this->{$this->getKeyName()});
    }
}
