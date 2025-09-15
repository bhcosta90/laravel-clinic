<?php

declare(strict_types = 1);

namespace App\Models\Traits;

use InvalidArgumentException;
use Vinkla\Hashids\Facades\Hashids;

trait HashCode
{
    public static function decodeHashCode(string $hashCode): int
    {
        $decoded = Hashids::connection('code')->decode($hashCode);

        if (empty($decoded)) {
            throw new InvalidArgumentException('Invalid hash code provided.');
        }

        return (int) $decoded[0];
    }

    public function getHashCodeAttribute(): string
    {
        return Hashids::connection('code')->encode($this->{$this->getKeyName()});
    }
}
