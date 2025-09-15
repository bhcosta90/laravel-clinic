<?php

declare(strict_types = 1);

namespace Costa\Service\Traits;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use ReflectionMethod;
use ReflectionNamedType;
use RuntimeException;

trait HandlesWithDependencies
{
    public function handle(string $method, ...$params): mixed
    {
        $this->validateDataForMethod($method, $params);

        $container   = app(Container::class);
        $application = app(Application::class);

        $reflection = new ReflectionMethod(static::class, $method);
        $parameters = $reflection->getParameters();

        $bindClass = app(static::class);

        if (count($parameters) === count($params)) {
            return $bindClass->$method(...$params);
        }

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
                    array_map(fn ($p): bool => $p instanceof $className, $paramsQueue),
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
            throw new InvalidArgumentException("It was not possible to resolve the parameter \${$name} no method {$method} of " . static::class);
        }

        return $bindClass->$method(...$resolved);
    }

    protected function debug(bool $method, Closure $closure): void
    {
        if ($method) {
            $closure();
        }
    }

    protected function validateDataForMethod(string $method, array $params): void
    {
        $rulesMethod = 'rulesFor' . ucfirst($method);

        if (!method_exists($this, $rulesMethod)) {
            return;
        }

        $rules = $this->$rulesMethod();

        if (!is_array($rules)) {
            throw new RuntimeException("O método {$rulesMethod} deve retornar um array de regras de validação.");
        }

        $data = $this->mapParamsToValidationData($rules, $params);

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    protected function mapParamsToValidationData(array $rules, array $params): array
    {
        // Simples: assume que $params está na mesma ordem das chaves de $rules
        $data = [];
        $i    = 0;

        foreach (array_keys($rules) as $key) {
            if (isset($params[$i])) {
                $data[$key] = $params[$i];
            }
            ++$i;
        }

        return $data;
    }
}
