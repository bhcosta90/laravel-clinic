<?php

declare(strict_types=1);

namespace App\Traits\Models;

use Illuminate\Support\Carbon;

trait CastsDatesToUserTimezone
{
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if ($this->shouldConvertToLocalTime($key, $value)) {
            return $value->copy()->timezone($this->getUserTimezone());
        }

        return $value;
    }

    protected function getUserTimezone(): string
    {
        return auth()->user()?->timezone ?? 'America/Sao_Paulo';
    }

    protected function shouldConvertToLocalTime(string $key, mixed $value): bool
    {
        if (!$value instanceof Carbon) {
            return false;
        }

        return in_array($key, $this->getDates(), true)
        || (property_exists($this, 'casts')
            && isset($this->casts[$key])
            && str_contains((string) $this->casts[$key], 'date'));
    }
}
