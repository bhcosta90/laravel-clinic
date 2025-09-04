<?php

declare(strict_types = 1);

namespace App\Traits\Services;

use Closure;
use Exception;
use Illuminate\Container\Container;
use Illuminate\Foundation\Application;
use ReflectionMethod;
use ReflectionNamedType;

trait HandlesWithDependencies
{
    public function handle(string $method, ...$params): mixed
    {
        $container = app(Container::class);

        $reflection = new ReflectionMethod(static::class, $method);

        $parameters = $reflection->getParameters();
        $resolved   = [];

        $application = app(Application::class);

        if (count($params) === count($parameters)) {
            foreach ($parameters as $index => $parameter) {
                $resolved[$index] = $params[$index];
            }

            return app(static::class)->$method(...$resolved);
        }

        try {
            foreach ($parameters as $key => $parameter) {
                foreach ($parameter->getAttributes() as $attribute) {
                    $instance = $attribute->newInstance();

                    if (method_exists($instance, 'resolve')) {
                        $resolved[$key] = $instance->resolve($instance, $container);

                        continue 2;
                    }
                }

                $type = $parameter->getType();

                if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                    $resolved[$key] = $application->make($type->getName());

                    continue;
                }

                $resolved[$key] = array_shift($params);
            }
        } catch (Exception) {
            //
        }

        $this->debug('registerError' === $method, fn () => dd($resolved));

        return app(static::class)->$method(...$resolved);
    }

    protected function debug(bool $method, Closure $closure): void
    {
        if ($method) {
            $closure();
        }
    }
}
