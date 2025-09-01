<?php

declare(strict_types = 1);

namespace App\Traits\Services;

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
                $resolved[$parameter->name] = $params[$index];
            }

            return app(static::class)->$method(...$resolved);
        }

        foreach ($parameters as $parameter) {
            foreach ($parameter->getAttributes() as $attribute) {
                $instance = $attribute->newInstance();

                if (method_exists($instance, 'resolve')) {
                    $resolved[$parameter->name] = $instance->resolve($instance, $container);

                    continue 2;
                }
            }

            $type = $parameter->getType();

            if ($type instanceof ReflectionNamedType && !$type->isBuiltin()) {
                $resolved[$parameter->name] = $application->make($type->getName());

                continue;
            }

            $resolved[$parameter->name] = array_shift($params);
        }

        return app(static::class)->$method(...$resolved);
    }
}
