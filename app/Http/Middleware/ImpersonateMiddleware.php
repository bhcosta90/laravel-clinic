<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

final class ImpersonateMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Cache::get('impersonate_actual') && Cache::get('impersonate_new')) {
            Auth::onceUsingId(Cache::get('impersonate_new'));
        }

        return $next($request);
    }
}
