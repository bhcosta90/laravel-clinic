<?php

declare(strict_types = 1);

namespace App\Repository\Auditing;

use Illuminate\Support\Facades\Cache;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\Resolver;

final class ImpersonateResolver implements Resolver
{
    public static function resolve(Auditable $auditable): ?string
    {
        return Cache::get('impersonate_new');
    }
}
