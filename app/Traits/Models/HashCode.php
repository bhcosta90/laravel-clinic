<?php

declare(strict_types = 1);

namespace App\Traits\Models;

use Vinkla\Hashids\Facades\Hashids;

trait HashCode
{
    public static function decodeHashCode(string $hashCode): int
    {
        $decoded = Hashids::connection('code')->decode($hashCode);

        if (empty($decoded)) {
            return 0;
        }

        return (int) $decoded[0];
    }

    public function getHashCodeAttribute(): string
    {
        return Hashids::connection('code')->encode($this->{$this->getKeyName()});
    }
}
