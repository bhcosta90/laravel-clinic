<?php

declare(strict_types = 1);

namespace App\Traits\Services;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Foundation\Application;
use InvalidArgumentException;
use ReflectionMethod;
use ReflectionNamedType;

trait HandlesWithDependencies
{
    public function handle(string $method, ...$params): mixed
    {
        $container   = app(Container::class);
        $application = app(Application::class);

        $reflection = new ReflectionMethod(static::class, $method);
        $parameters = $reflection->getParameters();

        $resolved    = [];
        $paramsQueue = $params; // fila de parâmetros manuais que vamos consumindo

        foreach ($parameters as $parameter) {
            $name = $parameter->getName();

            // 1) First tries to solve by attribute (ex: #[CurrentUser])
            foreach ($parameter->getAttributes() as $attribute) {
                $instance = $attribute->newInstance();

                if (method_exists($instance, 'resolve')) {
                    $resolved[$name] = $instance->resolve($instance, $container);

                    continue 2; // vai para o próximo parâmetro
                }
            }

            $type = $parameter->getType();

            // 2) If it's a class (ReflectionNamedType no-builtin), Try to get the line or container
            if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                $className = $type->getName();

                // tenta ver se o chamador passou manualmente uma instância desse tipo
                $matchIndex = array_search(
                    true,
                    array_map(fn ($p) => is_object($p) && $p instanceof $className, $paramsQueue),
                    true
                );

                if (false !== $matchIndex) {
                    $resolved[$name] = $paramsQueue[$matchIndex];
                    unset($paramsQueue[$matchIndex]);

                    continue;
                }

                // else, resolve via container
                $resolved[$name] = $application->make($className);

                continue;
            }

            // 3) If something is still left in the line of Params, consumes in order
            if (count($paramsQueue) > 0) {
                $resolved[$name] = array_shift($paramsQueue);

                continue;
            }

            // 4) If the parameter has value default, uses
            if ($parameter->isDefaultValueAvailable()) {
                $resolved[$name] = $parameter->getDefaultValue();

                continue;
            }

            // 5) If you arrived here, we have no value to pass - error
            throw new InvalidArgumentException("Não foi possível resolver o parâmetro \${$name} no método {$method} de " . static::class);
        }

        return app(static::class)->$method(...$resolved);
    }

    protected function debug(bool $method, Closure $closure): void
    {
        if ($method) {
            $closure();
        }
    }
}
