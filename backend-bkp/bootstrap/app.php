<?php

declare(strict_types = 1);

use Core\Shared\Application\Exception\BaseException;
use Core\Shared\Domain\Exception\ValidationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (BaseException | ValidationException $e) {
            Log::debug($e->getMessage(), [
                'exception' => $e,
                'file'      => $e->getFile(),
                'line'      => $e->getLine(),
            ]);

            $response = [
                'message' => $e->getMessage(),
            ];

            if ($e instanceof ValidationException) {
                $response['errors'] = $e->getErrors();
            }

            // Retorna resposta JSON normalmente
            return response()->json($response, $e->getCode() ?: 400); // garante código válido
        });
    })->create();
