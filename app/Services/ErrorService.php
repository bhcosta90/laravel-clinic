<?php

declare(strict_types = 1);

namespace App\Services;

use App\Abstracts\Service;
use App\Models\Error;
use Closure;
use Exception;
use Illuminate\Validation\ValidationException;

final class ErrorService extends Service
{
    public function registerError(string $type, Closure $callback): mixed
    {
        $data = [];

        try {
            return $callback();
        } catch (ValidationException $e) {
            $data = array_merge($data, [
                'message' => $e->getMessage(),
                'data'    => [
                    'file'     => $e->getFile(),
                    'line'     => $e->getLine(),
                    'trace'    => $e->getTrace(),
                    'code'     => $e->getCode(),
                    'previous' => $e->getPrevious()?->getMessage(),
                    'errors'   => $e->errors(),
                ],
            ]);
        } catch (Exception $e) {
            $data = array_merge($data, [
                'message' => $e->getMessage(),
                'data'    => [
                    'file'     => $e->getFile(),
                    'line'     => $e->getLine(),
                    'trace'    => $e->getTrace(),
                    'code'     => $e->getCode(),
                    'previous' => $e->getPrevious()?->getMessage(),
                ],
            ]);
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
