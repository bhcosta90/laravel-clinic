<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Enums\Models\Error\Type;
use App\Models\Error;
use Closure;
use Exception;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Validation\ValidationException;

final class ErrorService extends Service
{
    public function removeErrorFromUser(#[CurrentUser] $user): bool
    {
        return (bool) $this->model()->where('user_id', $user?->id)->forceDelete();
    }

    public function registerError(#[CurrentUser] $user, Type $type, string | int $code, Closure $callback): mixed
    {
        //        $event = new LocationErrorEvent($user->id, $type);

        $data = ['type' => $type, 'code' => $code];

        try {
            return $callback();
        } catch (ValidationException $e) {
            $data = array_merge($data, [
                'exception' => $e::class,
                'message'   => $e->getMessage(),
                'data'      => $e->errors(),
            ]);
            //            broadcast($event);
        } catch (Exception $e) {
            $data = array_merge($data, [
                'exception' => $e::class,
                'message'   => $e->getMessage(),
                'data'      => [
                    'file'     => $e->getFile(),
                    'line'     => $e->getLine(),
                    'trace'    => $e->getTrace(),
                    'code'     => $e->getCode(),
                    'previous' => $e->getPrevious()?->getMessage(),
                ],
            ]);
            //            broadcast($event);
        }

        if (filled($data)) {
            $this->store($data);
        }

        return null;
    }

    protected function model(): Error
    {
        return new Error();
    }

    protected function search(): array
    {
        return ['type'];
    }
}
