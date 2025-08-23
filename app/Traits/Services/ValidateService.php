<?php

declare(strict_types = 1);

namespace App\Traits\Services;

use App\Models\User;
use Illuminate\Http\Response;
use Throwable;

trait ValidateService
{
    protected function validate(string $request, array $data, ?User $user = null): array
    {
        $request = new $request();

        $request->merge($data);

        $request->setUserResolver(fn () => auth()->user());

        if (!$request->authorize()) {
            abort(Response::HTTP_FORBIDDEN, 'Unauthorized action.');
        }

        try {
            return validator($request->all(), $request->rules())->validate();
        } catch (Throwable $e) {
            throw $e;
        }
    }
}
