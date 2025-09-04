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

            // 1) Primeiro tenta resolver por atributo (ex: #[CurrentUser])
            foreach ($parameter->getAttributes() as $attribute) {
                $instance = $attribute->newInstance();

                if (method_exists($instance, 'resolve')) {
                    $resolved[$name] = $instance->resolve($instance, $container);

                    continue 2; // vai para o próximo parâmetro
                }
            }

            $type = $parameter->getType();

            // 2) Se for uma classe (ReflectionNamedType não-builtin), tenta pegar da fila ou container
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

                // senão, resolve via container
                $resolved[$name] = $application->make($className);

                continue;
            }

            // 3) Se ainda sobrou algo na fila de params, consome na ordem
            if (count($paramsQueue) > 0) {
                $resolved[$name] = array_shift($paramsQueue);

                continue;
            }

            // 4) Se o parâmetro tem valor default, usa
            if ($parameter->isDefaultValueAvailable()) {
                $resolved[$name] = $parameter->getDefaultValue();

                continue;
            }

            // 5) Se chegou aqui, não temos valor para passar — erro
            throw new InvalidArgumentException("Não foi possível resolver o parâmetro \${$name} no método {$method} de " . static::class);
        }

        // Chama o método original com todos os parâmetros resolvidos
        return app(static::class)->$method(...$resolved);
    }

    protected function debug(bool $method, Closure $closure): void
    {
        if ($method) {
            $closure();
        }
    }
}
